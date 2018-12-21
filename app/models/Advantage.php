<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    protected $fillable = ['percent', 'serve_id', 'tenant_id'];
    
    public function serve() {
        return $this->belongsTo(Serve::class, 'serve_id');
    }
    
    public function tenant() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
