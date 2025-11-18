<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'proposal_number',
        'title',
        'date',
        'valid_until',
        'services',
        'total_amount',
        'notes',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'valid_until' => 'date',
        'services' => 'array',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the client that owns the proposal
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Generate a unique proposal number
     */
    public static function generateProposalNumber(): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $lastProposal = self::whereYear('created_at', $year)
            ->whereMonth('created_at', now()->month)
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastProposal ? (int) substr($lastProposal->proposal_number, -4) + 1 : 1;

        return 'PROP-' . $year . $month . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
