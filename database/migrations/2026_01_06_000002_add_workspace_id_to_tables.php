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
        // Add workspace_id to clients table
        Schema::table('clients', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add workspace_id to projects table
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add workspace_id to expenses table
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add workspace_id to businesses table
        Schema::table('businesses', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add workspace_id to proposals table
        Schema::table('proposals', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add workspace_id to expense_categories table
        Schema::table('expense_categories', function (Blueprint $table) {
            $table->foreignId('workspace_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        // Add current_workspace_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('current_workspace_id')->nullable()->after('id')->constrained('workspaces')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['current_workspace_id']);
            $table->dropColumn('current_workspace_id');
        });

        Schema::table('expense_categories', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });

        Schema::table('businesses', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign(['workspace_id']);
            $table->dropColumn('workspace_id');
        });
    }
};

