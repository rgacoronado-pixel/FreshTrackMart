<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'barcode',
        'stock',
        'spoiled_stock',
        'price',
        'low_stock_threshold',
        'description',
        'supplier',
        'status',
        'updated_by',
    ];

    protected $casts = [
        'stock' => 'integer',
        'spoiled_stock' => 'integer',
        'price' => 'decimal:2',
        'low_stock_threshold' => 'integer',
        'updated_by' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function alerts(): HasMany
    {
        return $this->hasMany(StockAlert::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        if ($this->relationLoaded('category') && $this->category) {
            return (string) $this->category->name;
        }

        $legacyCategory = $this->getAttribute('category');
        if (is_string($legacyCategory) && $legacyCategory !== '') {
            return $legacyCategory;
        }

        return 'uncategorized';
    }
}

