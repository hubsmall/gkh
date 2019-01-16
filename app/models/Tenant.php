<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['name', 'passport'];
    
    public function flats() {
        return $this->hasMany(Flat::class, 'tenant_id');
    }
    
    public function privileges() {
        return $this->hasMany(Privilege::class, 'tenant_id');
    }
    
}
