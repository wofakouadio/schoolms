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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('invoice_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('term_id')->nullable();
            $table->string('academic_year_id')->nullable();
            $table->string('description')->nullable();
            $table->string('currency')->nullable();
            $table->float('amount_due')->default('0.00');
            $table->float('amount_paid')->default('0.00');
            $table->float('balance')->default('0.00');
            $table->string('transaction_type')->nullable();
            $table->string('items')->nullable();
            $table->string('payment_status')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->string('reference')->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students_admissions')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
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
        Schema::dropIfExists('transactions');
    }
};
