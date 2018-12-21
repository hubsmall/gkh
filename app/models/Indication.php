<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Indication extends Model
{
    protected $fillable = ['indication', 'serve_id', 'tenant_id'];
    
    public function serve() {
        return $this->belongsTo(Serve::class, 'serve_id');
    }
    
    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
