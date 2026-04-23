<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'reference_type',
        'reference_id',
        'movement_type',
        'quantity_before',
        'quantity_change',
        'quantity_after',
        'unit_price',
        'total_amount',
        'tags',
        'notes',
        'performed_by',
    ];

    protected $casts = [
        'quantity_before' => 'integer',
        'quantity_change' => 'integer',
        'quantity_after' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'tags' => 'array',
    ];

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
