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
        Schema::create('grading_systems', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('academic_year')->nullable();
            $table->string('score_from')->nullable();
            $table->string('score_to')->nullable();
            $table->string('grade')->nullable();
            $table->string('level_of_proficiency')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_systems');
    }
};
