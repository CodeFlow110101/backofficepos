<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesStock extends Model
{
    protected $table = 'salestocks';

    protected $fillable = ['sale_id', 'stock_id', 'quantity'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'stock_id', 'id');
    }
}
