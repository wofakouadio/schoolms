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
            $table->string('student_firstname');
            $table->string('student_othername')->nullable();
            $table->string('student_lastname');
            $table->string('student_gender');
            $table->string('student_dob');
            $table->string('student_pob');
            $table->string('student_branch');
            $table->string('student_level');
            $table->string('student_house');
            $table->string('student_category')->nullable();
            $table->string('student_residency_type');
            $table->string('student_guardian_name');
            $table->string('student_guardian_contact');
            $table->string('student_guardian_address');
            $table->string('student_guardian_email');
            $table->string('student_guardian_occupation');
            $table->tinyInteger('admission_status')->default(0);
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
