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
        Schema::create('class_assessment_settings', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('term_id')->nullable();
            $table->string('academic_year_id')->nullable();
            $table->string('class_assessment_size')->nullable();
            $table->string('add_mid_term')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_assessment_settings');
    }
};
