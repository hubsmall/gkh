<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Quietus extends Model
{
    protected $fillable = ['pay_status', 'flat_id', 'tenant_id'];
    
    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }
    
    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
