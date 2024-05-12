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
        Schema::create('subjects_to_teachers', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('teacher_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('subject_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects_to_teachers');
    }
};
