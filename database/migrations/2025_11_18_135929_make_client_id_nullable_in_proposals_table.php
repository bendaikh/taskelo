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
        Schema::table('proposals', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropForeign(['client_id']);
            // Make client_id nullable
            $table->unsignedBigInteger('client_id')->nullable()->change();
            // Re-add the foreign key constraint (nullable)
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['client_id']);
            // Make client_id required again
            $table->unsignedBigInteger('client_id')->nullable(false)->change();
            // Re-add the foreign key constraint (required)
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
};
