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
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('teacher_staff_id')->nullable();
            $table->string('teacher_title');
            $table->string('teacher_firstname');
            $table->string('teacher_othername')->nullable();
            $table->string('teacher_lastname');
            $table->string('teacher_gender');
            $table->string('teacher_dob');
            $table->string('teacher_pob');
            $table->string('teacher_nationality')->nullable();
            $table->string('teacher_address')->nullable();
            $table->string('teacher_email')->unique();
            $table->string('teacher_contact')->unique();
            $table->string('teacher_school_attended')->nullable();
            $table->string('teacher_admission_year')->nullable();
            $table->string('teacher_completion_year')->nullable();
            $table->string('teacher_country')->nullable();
            $table->string('teacher_region')->nullable();
            $table->string('teacher_district')->nullable();
            $table->string('teacher_first_app')->nullable();
            $table->string('teacher_present_school')->nullable();
            $table->string('teacher_qualification')->nullable();
            $table->string('teacher_professional')->nullable();
            $table->string('teacher_rank')->nullable();
            $table->string('teacher_circuit')->nullable();
            $table->string('teacher_reg_number')->nullable();
            $table->string('teacher_district_file_number')->nullable();
            $table->string('teacher_bank_name')->nullable();
            $table->string('teacher_account_number')->nullable();
            $table->string('teacher_bank_branch')->nullable();
            $table->string('teacher_ssnit')->nullable();
            $table->string('teacher_ntc')->nullable();
            $table->string('teacher_ghana_card')->nullable();
            $table->string('teacher_password');
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
