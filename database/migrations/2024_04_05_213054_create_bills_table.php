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
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('bill_amount');
            $table->longText('bill_description')->nullable();
            $table->string('academic_year')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->string('term_id')->nullable();
            $table->string('level_id')->nullable();
            $table->string('school_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
