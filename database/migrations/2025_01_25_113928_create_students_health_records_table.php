<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students_health_records', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('student_birth_type')->nullable();
            $table->string('student_birth_type_other')->nullable();
            $table->string('student_weight')->nullable();
            $table->string('student_having_chronic_disease')->nullable();
            $table->string('student_has_chronic_disease')->nullable();
            $table->string('student_having_generic_disease')->nullable();
            $table->string('student_has_generic_disease')->nullable();
            $table->string('student_having_allergies')->nullable();
            $table->string('student_has_allergies')->nullable();
            $table->string('student_having_stitches')->nullable();
            $table->string('student_has_stitches')->nullable();
            $table->string('causes_for_student_has_stitches')->nullable();
            $table->string('student_other_health_info')->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students_admissions')->cascadeOnDelete();
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
        Schema::dropIfExists('students_health_records');
    }
};
