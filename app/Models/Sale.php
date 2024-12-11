<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $table = "sales";

    protected $fillable = ['delivery_id', 'stall', 'file_name', 'file_path'];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }

    public function salestocks(): HasMany
    {
        return $this->hasMany(SalesStock::class, 'sale_id', 'id');
    }
}
