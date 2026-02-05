<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['project_id']);
        });

        // Make project_id nullable (using DB::statement for better compatibility)
        DB::statement('ALTER TABLE tasks MODIFY project_id BIGINT UNSIGNED NULL');

        Schema::table('tasks', function (Blueprint $table) {
            // Re-add foreign key constraint with nullable support
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            
            // Add workspace_id for filtering tasks by workspace
            $table->foreignId('workspace_id')->nullable()->after('project_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Drop workspace_id
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
            
            // Drop project_id foreign key
            $table->dropForeign(['project_id']);
        });

        // Revert project_id to required (first delete any null values or handle them)
        // Note: This will fail if there are tasks with null project_id
        DB::statement('ALTER TABLE tasks MODIFY project_id BIGINT UNSIGNED NOT NULL');

        Schema::table('tasks', function (Blueprint $table) {
            // Re-add foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }
};
