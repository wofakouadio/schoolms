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
        Schema::create('mock_breakdowns', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('mock_student_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('mock_id')->nullable();
            $table->string('term_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('score')->nullable();
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
        Schema::dropIfExists('mock_breadowns');
    }
};
