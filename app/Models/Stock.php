<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'warehouse_id',
        'inventory_id',
        'price',
        'quantity',
    ];
}
