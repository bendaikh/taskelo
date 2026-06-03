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
        Schema::table('project_sections', function (Blueprint $table) {
            $table->decimal('remise', 10, 2)->default(0)->after('total_price');
            $table->string('remise_type', 10)->default('fixed')->after('remise');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_sections', function (Blueprint $table) {
            $table->dropColumn(['remise', 'remise_type']);
        });
    }
};
