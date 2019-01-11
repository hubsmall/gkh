<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Quietu extends Model {

    protected $fillable = ['pay_status', 'flat_id'];

    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }

    public $belongsTo = ['flat.block.street'];
    public $parents = [Flat::class];
    public $grandparents = [Street::class];
    public $ancestorForThrough = Block::class;

    public function getcalculateAttribute() {
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
            $indication = Indication::where('flat_id', $this->flat_id)->where('serve_id', $indicationServe->id)->orderBy('created_at', 'desc')->first();
            $total = $total + $indicationServe->tariff * $indication->indication;
        }
        return $total;
    }

}
