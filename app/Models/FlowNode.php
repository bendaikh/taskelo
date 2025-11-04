<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlowNode extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'title',
        'description',
        'status',
        'color',
        'icon',
        'position_x',
        'position_y',
    ];

    protected $casts = [
        'position_x' => 'decimal:2',
        'position_y' => 'decimal:2',
    ];

    /**
     * Get the business that owns this node
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get all outgoing edges from this node
     */
    public function outgoingEdges(): HasMany
    {
        return $this->hasMany(FlowEdge::class, 'from_node_id');
    }

    /**
     * Get all incoming edges to this node
     */
    public function incomingEdges(): HasMany
    {
        return $this->hasMany(FlowEdge::class, 'to_node_id');
    }
}
