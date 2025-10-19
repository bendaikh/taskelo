<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'status',
        'price',
        'deadline',
        'description',
    ];

    protected $casts = [
        'deadline' => 'date',
        'price' => 'decimal:2',
    ];

    /**
     * Get the project that owns the task
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Check if the task is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->deadline || $this->status === 'done') {
            return false;
        }

        return $this->deadline->isPast();
    }
}

