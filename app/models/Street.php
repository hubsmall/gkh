<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    protected $fillable = ['name'];
    
    public function blocks() {
        return $this->hasMany(Block::class, 'street_id');
    }
    
    public function grandchildren()
    {
        return $this->hasManyThrough(Flat::class, Block::class);
    }
      
    public static function hasManys() {
        return 'blocks';
    }
    
    
}
