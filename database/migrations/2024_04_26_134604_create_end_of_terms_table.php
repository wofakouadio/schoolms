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
        Schema::create('end_of_terms', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('term_id')->nullable();
            $table->string('total_class_score')->nullable();
            $table->string('total_exam_score')->nullable();
            $table->string('total_score')->nullable();
            $table->string('conduct')->nullable();
            $table->string('attitude')->nullable();
            $table->string('interest')->nullable();
            $table->string('general_remarks')->nullable();
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
        Schema::dropIfExists('end_of_terms');
    }
};
