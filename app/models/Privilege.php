<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\models;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Privilege
 *
 * @author vova
 */
class Privilege extends Model {
    
    protected $fillable = ['tenant_id', 'advantage_id'];
    
    public function owner() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
    
    public function advantage() {
        return $this->belongsTo(Advantage::class, 'advantage_id');
    }
    
    public $belongsTo = ['owner','advantage'];
    
    public $parents = [Tenant::class,Advantage::class];
    
}
