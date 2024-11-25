<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = "inventories";

    protected $fillable = ['name', 'description', 'price', 'quantity_type_id'];

    public function quantitytype(): BelongsTo
    {
        return $this->belongsTo(QuantityType::class, 'quantity_type_id', 'id');
    }
}
