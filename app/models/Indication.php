<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Indication extends Model
{
    protected $fillable = ['indication', 'serve_id', 'flat_id', 'date'];
    
    public function serve() {
        return $this->belongsTo(Serve::class, 'serve_id');
    }
    
    public function flat() {
        return $this->belongsTo(Flat::class, 'flat_id');
    }
    
    public $belongsTo = ['serve','flat.block.street'];
    
    public $parents = [Serve::class,Flat::class];
    
    public $grandparents = [Street::class,Serve::class];
    
    public $ancestorForThrough= Block::class;
}
