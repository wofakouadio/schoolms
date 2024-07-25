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
        Schema::create('billing_logs', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('term_id')->nullable();
            $table->string('academic_year_id')->nullable();            
            $table->float('amount_billed')->default('0');          
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students_admissions')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_logs');
    }
};
