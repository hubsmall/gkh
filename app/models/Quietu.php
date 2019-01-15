<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Quietu extends Model {

    protected $fillable = ['pay_status', 'flat_id', 'date'];

    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }

    public $belongsTo = ['flat.block.street'];
    public $parents = [Flat::class];
    public $grandparents = [Street::class];
    public $ancestorForThrough = Block::class;

    public function month() {
        return date('m', strtotime($this->date));
        ;
    }

    public function year() {
        return date('Y', strtotime($this->date));
        ;
    }

    public function getcalculateAttribute() {
        $year = date('Y', strtotime($this->date));
        $month = date('m', strtotime($this->date));
        $total = 0;
        $serves = Serve::all();
        // count on area
        $areaServes = $serves->where('unit', 'm^2');
        $area = $this->flat->area;
        foreach ($areaServes as $areaServe) {
            $total = $total + $areaServe->tariff * $area;
        }
        // count on indications
        $indicationServes = $serves->where('unit', '!==', 'm^2');
        foreach ($indicationServes as $indicationServe) {
            $monthIndications = Indication::where('flat_id', $this->flat_id)
                    ->where('serve_id', $indicationServe->id)
                    ->whereYear('date', $this->year())
                    ->whereMonth('date', $this->month())
                    ->get();
            foreach ($monthIndications as $monthIndication) {
                $total = $total + $indicationServe->tariff * $monthIndication->indication;
            }
        }
        return $total;
    }
   
    public function getIndicationForServe($serve) {
        $total = 0;
        $indications = Indication::where('flat_id', $this->flat_id)
                ->where('serve_id', $serve->id)
                ->whereYear('date', $this->year())
                ->whereMonth('date', $this->month())
                ->get();
        foreach ($indications as $indication) {
            $total += $indication->indication;
        }
        return $total;
    }

    public function calculateForIndicationServe($serve) {
        $total = 0;
        $indications = Indication::where('flat_id', $this->flat_id)
                ->where('serve_id', $serve->id)
                ->whereYear('date', $this->year())
                ->whereMonth('date', $this->month())
                ->get();
        foreach ($indications as $indication) {
            $total += $indication->indication * $serve->tariff;
        }
        return $total;
    }
    
    public function calculateForAreaServe($serve) {
        return $this->flat->area * $serve->tariff;
    }

}
