<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'description',
        'sections',
        'total_price',
        'remise',
        'remise_type',
        'currency',
        'date',
        'valid_until',
        'notes',
        'status',
    ];

    protected $casts = [
        'sections' => 'array',
        'total_price' => 'decimal:2',
        'remise' => 'decimal:2',
        'date' => 'date',
        'valid_until' => 'date',
    ];

    /**
     * Sum of all section prices before remise.
     */
    public function getSubtotalAttribute(): float
    {
        return round(collect($this->sections)->sum(function ($section) {
            return floatval($section['price'] ?? 0);
        }), 2);
    }

    /**
     * Discount amount applied to the subtotal.
     */
    public function getRemiseAmountAttribute(): float
    {
        $remise = floatval($this->remise ?? 0);
        if ($remise <= 0) {
            return 0;
        }

        $subtotal = $this->subtotal;
        if ($subtotal <= 0) {
            return 0;
        }

        if ($this->remise_type === 'percent') {
            return round(min($subtotal, $subtotal * min($remise, 100) / 100), 2);
        }

        return round(min($remise, $subtotal), 2);
    }

    /**
     * Calculate subtotal and total price after remise.
     */
    public static function calculateTotals(array $sections, ?float $remise = 0, ?string $remiseType = 'fixed'): array
    {
        $subtotal = round(collect($sections)->sum(function ($section) {
            return floatval($section['price'] ?? 0);
        }), 2);

        $remise = floatval($remise ?? 0);
        $remiseType = $remiseType === 'percent' ? 'percent' : 'fixed';
        $remiseAmount = 0;

        if ($remise > 0 && $subtotal > 0) {
            $remiseAmount = $remiseType === 'percent'
                ? round(min($subtotal, $subtotal * min($remise, 100) / 100), 2)
                : round(min($remise, $subtotal), 2);
        }

        return [
            'subtotal' => $subtotal,
            'remise_amount' => $remiseAmount,
            'total_price' => round(max(0, $subtotal - $remiseAmount), 2),
        ];
    }

    /**
     * Get the user that owns the conception
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the client that this conception is for
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Generate a unique conception number
     */
    public static function generateConceptionNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $lastConception = self::whereYear('created_at', $year)
            ->whereMonth('created_at', now()->month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastConception ? (int) substr($lastConception->id, -4) + 1 : 1;

        return 'CONC-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}

