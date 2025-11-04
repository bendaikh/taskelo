<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flow_edges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_node_id')->constrained('flow_nodes')->onDelete('cascade');
            $table->foreignId('to_node_id')->constrained('flow_nodes')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate edges
            $table->unique(['from_node_id', 'to_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_edges');
    }
};
