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
        Schema::table('end_of_term_breakdowns', function (Blueprint $table) {
            $table->foreign('end_term_student_id')->references('id')->on('end_of_terms')->cascadeOnDelete();
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
        Schema::table('end_of_term_breakdowns', function (Blueprint $table) {
            $table->string('end_term_student_id');
            $table->string('student_id');
            $table->string('term_id');
            $table->string('subject_id');
            $table->string('school_id');
            $table->string('branch_id');
        });
    }
};
