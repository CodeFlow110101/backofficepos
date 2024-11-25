<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveyStock extends Model
{
    protected $table = "deliverystocks";

    protected $fillable = ['stock_id', 'quantity', 'delivery_id'];
}
