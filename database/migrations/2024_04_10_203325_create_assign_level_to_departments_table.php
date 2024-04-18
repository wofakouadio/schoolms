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
        Schema::create('assign_level_to_departments', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('department_id');
            $table->string('level_id');
            $table->string('school_id');
            $table->string('branch_id');
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_level_to_departments');
    }
};
