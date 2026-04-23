<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpoilageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'quantity',
        'reason',
        'detected_at',
        'detected_by',
        'stock_before',
        'stock_after',
        'spoiled_before',
        'spoiled_after',
        'status',
        'refund_sale_id',
        'refund_processed_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'stock_before' => 'integer',
        'stock_after' => 'integer',
        'spoiled_before' => 'integer',
        'spoiled_after' => 'integer',
        'detected_at' => 'datetime',
        'refund_processed_at' => 'datetime',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function detector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'detected_by');
    }

    public function refundSale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'refund_sale_id');
    }
}
