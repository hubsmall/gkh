<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    protected $fillable = ['number','block_id'];
    
    public function block() {
        return $this->belongsTo(Block::class, 'block_id');
    }
}
