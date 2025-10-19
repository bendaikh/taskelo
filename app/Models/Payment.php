<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'client_id',
        'amount',
        'type',
        'date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    /**
     * Get the project that owns the payment
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the client that owns the payment
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Boot method to update project amount_paid when payment is created
     */
    protected static function booted(): void
    {
        static::created(function (Payment $payment) {
            $payment->project->increment('amount_paid', $payment->amount);
        });

        static::deleted(function (Payment $payment) {
            $payment->project->decrement('amount_paid', $payment->amount);
        });

        static::updated(function (Payment $payment) {
            if ($payment->isDirty('amount')) {
                $oldAmount = $payment->getOriginal('amount');
                $newAmount = $payment->amount;
                $difference = $newAmount - $oldAmount;
                
                $payment->project->increment('amount_paid', $difference);
            }
        });
    }
}

