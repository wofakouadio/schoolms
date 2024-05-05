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
        Schema::create('students_admissions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('student_firstname')->nullable();
            $table->string('student_othername')->nullable();
            $table->string('student_lastname')->nullable();
            $table->string('student_gender')->nullable();
            $table->string('student_dob')->nullable();
            $table->string('student_pob')->nullable();
            $table->string('student_branch')->nullable();
            $table->string('student_level')->nullable();
            $table->string('student_house')->nullable();
            $table->string('student_category')->nullable();
            $table->string('student_residency_type')->nullable();
            $table->string('student_guardian_name')->nullable();
            $table->string('student_guardian_contact')->nullable();
            $table->string('student_guardian_email')->nullable();
            $table->string('student_guardian_occupation')->nullable();
            $table->string('student_password')->nullable();
            $table->string('admission_status')->default(0);
            $table->tinyInteger('student_status')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_admissions');
    }
};
