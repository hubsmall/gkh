<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model {

    protected $fillable = ['number', 'block_id', 'tenant_id', 'area'];

    public function block() {
        return $this->belongsTo(Block::class, 'block_id');
    }

    public function owner() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function quietus() {
        return $this->hasMany(Quietu::class, 'flat_id');
    }

    public $belongsTo = ['owner', 'block.street'];
    public $parents = [Block::class, Tenant::class];
    public $grandparents = [Street::class, Tenant::class];
    public $ancestorForThrough = Street::class;

    public function getIndicationForServe($serve) {
        $indication = Indication::where('flat_id', $this->id)
                        ->where('serve_id', $serve->id)
                        ->orderBy('created_at', 'desc')->get();
        return $indication->indication;
    }

    public function calculateForIndicationServe($serve) {
        $indication = Indication::where('flat_id', $this->id)
                        ->where('serve_id', $serve->id)
                        ->orderBy('created_at', 'desc')->first();
        return $indication->indication * $serve->tariff;
    }

    public function calculateForAreaServe($serve) {
        return $this->area * $serve->tariff;
    }

    public function getDateOfLatestIndicationAttribute() {
        $indication = Indication::where('flat_id', $this->id)
                        ->orderBy('created_at', 'desc')->first();
        $year = date('Y', strtotime($indication->created_at));
        $month = date('m', strtotime($indication->created_at));
        return $month . '/' . $year;
    }

    public function getcalculateAttribute() {
        $total = 0;
        $serves = Serve::all();
        // count on area
        $areaServes = $serves->where('unit', 'm^2');
        $area = $this->area;
        foreach ($areaServes as $areaServe) {
            $total = $total + $areaServe->tariff * $area;
        }
        // count on indications
        $indicationServes = $serves->where('unit', '!==', 'm^2');
        foreach ($indicationServes as $indicationServe) {
            $indication = Indication::where('flat_id', $this->id)->where('serve_id', $indicationServe->id)->orderBy('created_at', 'desc')->first();
            $total = $total + $indicationServe->tariff * $indication->indication;
        }
        return $total;
    }

    public function getDebtAttribute() {
        $unpaidQuietus = Quietu::where('pay_status', 0)
                        ->where('flat_id', $this->id)->get();
        $debt = 0;
        foreach ($unpaidQuietus as $unpaidQuietu) {
            $year = date('Y', strtotime($unpaidQuietu->created_at));
            $month = date('m', strtotime($unpaidQuietu->created_at));
            $total = 0;
            $serves = Serve::all();
            // count on area
            $areaServes = $serves->where('unit', 'm^2');
            $area = $this->area;
            foreach ($areaServes as $areaServe) {
                $total = $total + $areaServe->tariff * $area;
            }
            // count on indications
            $indicationServes = $serves->where('unit', '!==', 'm^2');
            foreach ($indicationServes as $indicationServe) {
                $indication = Indication::where('flat_id', $this->id)
                        ->where('serve_id', $indicationServe->id)
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->first();
                $total = $total + $indicationServe->tariff * $indication->indication;
            }
            $debt += $total;
        }
        return $debt;
    }

}
