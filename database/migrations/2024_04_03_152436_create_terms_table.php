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
        Schema::create('terms', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('term_name')->nullable();
            $table->string('term_opening_date')->nullable();
            $table->string('term_closing_date')->nullable();
            $table->string('term_academic_year')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->string('school_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
