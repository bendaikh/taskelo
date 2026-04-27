<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'workspace_id',
        'name',
        'email',
        'phone',
        'company',
        'address',
        'notes',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Get the workspace this client belongs to
     */
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get all projects for this client
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get all payments for this client
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get all proposals for this client
     */
    public function proposals(): HasMany
    {
        return $this->hasMany(Proposal::class);
    }

    /**
     * Get the total outstanding balance for this client
     */
    public function getOutstandingBalanceAttribute(): float
    {
        return $this->projects->sum(function (Project $project) {
            $budget = $project->budget ?? 0;
            $basis = $budget > 0 ? (float) $budget : (float) ($project->tasks()->sum('price') ?? 0);
            $pending = $basis - (float) $project->amount_paid;
            return $pending > 0 ? $pending : 0.0;
        });
    }

    /**
     * Get the total revenue from this client
     */
    public function getTotalRevenueAttribute(): float
    {
        return $this->projects->sum('amount_paid');
    }
}

