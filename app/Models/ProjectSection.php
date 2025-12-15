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
        'date',
        'valid_until',
        'notes',
        'status',
    ];

    protected $casts = [
        'sections' => 'array',
        'total_price' => 'decimal:2',
        'date' => 'date',
        'valid_until' => 'date',
    ];

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

