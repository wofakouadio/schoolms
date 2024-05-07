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
        Schema::table('students_admissions', function (Blueprint $table) {
            $table->foreign('student_branch')->references('id')->on('branches')->cascadeOnDelete();
            $table->foreign('student_level')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('student_house')->references('id')->on('houses')->cascadeOnDelete();
            $table->foreign('student_category')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_admissions', function (Blueprint $table) {
            $table->string('student_branch');
            $table->string('student_level');
            $table->string('student_house');
            $table->string('student_category');
            $table->string('school_id');
        });
    }
};
