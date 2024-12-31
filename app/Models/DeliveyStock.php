<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveyStock extends Model
{
    protected $table = "deliverystocks";

    protected $fillable = ['stock_id', 'quantity', 'delivery_id', 'original_quantity'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
}
