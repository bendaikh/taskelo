<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlowEdge extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'from_node_id',
        'to_node_id',
    ];

    /**
     * Get the business that owns this edge
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get the source node
     */
    public function fromNode(): BelongsTo
    {
        return $this->belongsTo(FlowNode::class, 'from_node_id');
    }

    /**
     * Get the target node
     */
    public function toNode(): BelongsTo
    {
        return $this->belongsTo(FlowNode::class, 'to_node_id');
    }
}
