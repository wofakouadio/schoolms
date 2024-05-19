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
        Schema::table('assessment_settings', function (Blueprint $table) {
            $table->foreign('academic_year')->references('id')->on('academic_years')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessment_settings', function (Blueprint $table) {
            $table->string('academic_year');
        });
    }
};
