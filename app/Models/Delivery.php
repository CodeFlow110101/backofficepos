<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    protected $table = "deliveries";

    protected $fillable = ['warehouse_id', 'user_id', 'vehicle_no', 'issued_by'];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function issued_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by', 'id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(DeliveyStock::class, 'delivery_id', 'id');
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'delivery_id', 'id');
    }
}
