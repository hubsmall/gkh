<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Quietu extends Model
{
    protected $fillable = ['pay_status', 'flat_id'];
    
    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }
    
    
    public $belongsTo = ['flat.block.street'];
    
    public $parents = [Flat::class];
    
    public $grandparents = [Street::class];
    
    public $ancestorForThrough= Block::class;
    

}
