<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $fillable = ['number','block_id','tenant_id'];
    
    public function block() {
        return $this->belongsTo(Block::class, 'block_id');
    }
    
    public function owner() {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
    
    public $belongsTo = ['owner','block.street'];
    
    public $parents = [Block::class,Tenant::class];
    
    public $grandparents = [Street::class,Tenant::class];
    
}
