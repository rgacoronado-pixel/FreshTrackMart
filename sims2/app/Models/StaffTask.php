<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_code',
        'description',
        'area',
        'status',
        'assigned_to',
        'created_by',
        'due_at',
    ];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
