<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['number','street_id'];
    
    public function street() {
        return $this->belongsTo(Street::class, 'street_id');
    }
    
    public function flats() {
        return $this->hasMany(Flat::class, 'block_id');
    }
    
    public function indications()
    {
        return $this->hasManyThrough(Indication::class, Flat::class);
    }
    
    public function quietus()
    {
        return $this->hasManyThrough(Quietu::class, Flat::class);
    }
    
    public $belongsTo = ['street'];
    
    public $parents = ['\App\models\Street'];
    
}
