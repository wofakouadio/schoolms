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
        Schema::create('assessment_settings', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('academic_year')->nullable();
            $table->string('class_percentage')->nullable();
            $table->string('exam_percentage')->nullable();
            $table->string('mid_term_percentage')->nullable();
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
        Schema::dropIfExists('assessment_settings');
    }
};
