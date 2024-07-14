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
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('name')->nullable();
            $table->string('symbol')->nullable();
            $table->string('school_id')->nullable();
            $table->tinyInteger('is_default_currency')->default(0);
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
