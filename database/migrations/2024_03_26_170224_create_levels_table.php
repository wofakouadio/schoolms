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
        Schema::create('levels', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('level_name')->unique();
            $table->string('level_description')->nullable();
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('levels');
    }
};