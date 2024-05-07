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
        Schema::table('mid_term_breakdowns', function (Blueprint $table) {
            $table->foreign('mid_term_student_id')->references('id')->on('mid_terms')->cascadeOnDelete();
            $table->foreign('student_id')->references('id')->on('students_admissions')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mid_term_breakdowns', function (Blueprint $table) {
            $table->string('mid_term_student_id');
            $table->string('student_id');
            $table->string('term_id');
            $table->string('subject_id');
            $table->string('school_id');
            $table->string('branch_id');
        });
    }
};
