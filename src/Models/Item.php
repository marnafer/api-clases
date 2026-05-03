<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'name',
        'quantity',
        'price'
    ];

    public $timestamps = true;
}