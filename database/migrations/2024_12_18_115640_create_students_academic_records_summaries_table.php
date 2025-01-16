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
        Schema::create('students_academic_records_summaries', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('academic_year_id')->nullable();
            $table->string('term_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('class_total_score')->nullable();
            $table->string('class_total_score_percentage')->nullable();
            $table->string('mid_term_total_score')->nullable();
            $table->string('mid_term_total_score_percentage')->nullable();
            $table->string('end_term_total_score')->nullable();
            $table->string('end_term_total_score_percentage')->nullable();
            $table->string('total_score')->nullable();
            $table->string('total_score_percentage')->nullable();
            $table->string('grade_id')->nullable();
            $table->string('grade_level')->nullable();
            $table->string('grade_proficiency_level')->nullable();
            $table->string('promotion')->nullable();
            $table->string('conduct')->nullable();
            $table->string('attitude')->nullable();
            $table->string('interest')->nullable();
            $table->string('general_remarks')->nullable();
            $table->text('recommendations')->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students_admissions')->cascadeOnDelete();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('grade_id')->references('id')->on('grading_systems')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_academic_records_summaries');
    }
};
