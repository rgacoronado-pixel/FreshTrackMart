<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color', // for UI
    ];

    protected $casts = [
        'color' => 'string',
    ];

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}

