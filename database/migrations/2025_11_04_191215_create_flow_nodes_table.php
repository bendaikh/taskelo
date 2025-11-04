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
        Schema::create('flow_nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['planning', 'in_progress', 'completed'])->default('planning');
            $table->string('color')->default('#3B82F6'); // Default blue
            $table->string('icon')->nullable(); // Optional icon name
            $table->decimal('position_x', 10, 2)->default(100);
            $table->decimal('position_y', 10, 2)->default(100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow_nodes');
    }
};
