<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Expense;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'budget',
        'amount_paid',
        'status',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the client that owns the project
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all tasks for this project
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get all payments for this project
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all expenses for this project
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the pending amount for this project
     */
    public function getPendingAttribute(): float
    {
        $budget = $this->budget ?? 0;
        // If no budget defined, fall back to sum of task prices
        if ($budget <= 0) {
            $tasksTotal = (float) ($this->tasks()->sum('price') ?? 0);
            $basis = $tasksTotal;
        } else {
            $basis = (float) $budget;
        }

        $pending = $basis - (float) $this->amount_paid;
        return $pending > 0 ? $pending : 0.0;
    }

    /**
     * Get the progress percentage based on completed tasks
     */
    public function getProgressAttribute(): int
    {
        $totalTasks = $this->tasks()->count();
        
        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $this->tasks()->where('status', 'done')->count();
        
        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Get the payment completion percentage
     */
    public function getPaymentProgressAttribute(): int
    {
        $budget = $this->budget ?? 0;
        $basis = $budget > 0 ? (float) $budget : (float) ($this->tasks()->sum('price') ?? 0);
        if ($basis == 0.0) {
            return 0;
        }

        return (int) round(((float) $this->amount_paid / $basis) * 100);
    }
}

