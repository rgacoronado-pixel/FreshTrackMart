<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'alert_type', // low_stock, high_spoilage
        'threshold_value',
        'triggered_at',
        'resolved_at',
        'notified_users',
    ];

    protected $casts = [
        'threshold_value' => 'integer',
        'triggered_at' => 'datetime',
        'resolved_at' => 'datetime',
        'notified_users' => 'array',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}

