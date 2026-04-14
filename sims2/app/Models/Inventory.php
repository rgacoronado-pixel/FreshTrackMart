<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'stock',
        'price',
        'description',
        'supplier',
        'status',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price' => 'decimal:2',
    ];
}