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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('student_id')->nullable();
            $table->string('student_password');
            $table->tinyInteger('student_status')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->string('admission_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
