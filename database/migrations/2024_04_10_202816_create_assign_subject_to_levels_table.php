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
        Schema::create('assign_subject_to_levels', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('subject_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('is_active')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_subject_to_levels');
    }
};
