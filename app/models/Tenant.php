<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'passport', 'flat_id'];
    
    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }
}
