<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuantityType extends Model
{
    protected $table = "quantity_types";

    protected $fillable = ['name'];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'quantity_type_id', 'id');
    }
}
