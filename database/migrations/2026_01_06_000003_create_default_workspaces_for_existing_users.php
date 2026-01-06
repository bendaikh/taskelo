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
        // Create default workspace for each existing user
        $users = DB::table('users')->get();
        
        foreach ($users as $user) {
            // Create a default personal workspace for each user
            $workspaceId = DB::table('workspaces')->insertGetId([
                'name' => $user->name . "'s Workspace",
                'type' => 'personal',
                'description' => 'Default workspace',
                'owner_id' => $user->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add user to workspace_user pivot
            DB::table('workspace_user')->insert([
                'workspace_id' => $workspaceId,
                'user_id' => $user->id,
                'role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Set as current workspace
            DB::table('users')
                ->where('id', $user->id)
                ->update(['current_workspace_id' => $workspaceId]);

            // Assign all existing data to this workspace
            DB::table('clients')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);

            DB::table('projects')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);

            DB::table('expenses')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);

            DB::table('businesses')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);

            DB::table('proposals')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);

            DB::table('expense_categories')
                ->whereNull('workspace_id')
                ->update(['workspace_id' => $workspaceId]);
        }

        // Now make workspace_id required
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });

        Schema::table('expense_categories', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Make workspace_id nullable again
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });

        Schema::table('expense_categories', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->change();
        });
    }
};

