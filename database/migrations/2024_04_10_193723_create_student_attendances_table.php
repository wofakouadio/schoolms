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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id');
            $table->string('level_id');
            $table->string('subject_id');
            $table->string('department_id');
            $table->tinyInteger('status');
            $table->string('branch_id');
            $table->string('school_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
