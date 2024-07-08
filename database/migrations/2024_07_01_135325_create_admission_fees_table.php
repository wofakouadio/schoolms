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
        Schema::create('admission_fees', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('academic_year_id')->nullable();
            // $table->decimal('amount', 10, 2)->default('0.00');
            $table->float('amount')->default('0.00');
            $table->string('department_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_fees');
    }
};
