<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Serve extends Model
{
    protected $fillable = ['name', 'unit', 'tariff'];
}
