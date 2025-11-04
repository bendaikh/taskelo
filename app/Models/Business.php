<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
    ];

    /**
     * Get the user that owns the business
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all flow nodes for this business
     */
    public function flowNodes(): HasMany
    {
        return $this->hasMany(FlowNode::class);
    }

    /**
     * Get all flow edges for this business
     */
    public function flowEdges(): HasMany
    {
        return $this->hasMany(FlowEdge::class);
    }
}
