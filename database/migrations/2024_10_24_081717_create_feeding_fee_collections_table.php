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
        Schema::create('feeding_fee_collections', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('feeding_fee_id')->nullable();
            $table->string('week')->nullable();
            $table->string('date')->nullable();
            $table->string('level_id')->nullable();
            $table->string('number_of_presents')->nullable();
            $table->string('number_of_who_do_not_pay')->nullable();
            $table->string('number_of_credits')->nullable();
            $table->string('arrears_clearance')->nullable();
            $table->string('advance_payment')->nullable();
            $table->string('amount_realized')->nullable();
            $table->string('term_id')->nullable();
            $table->string('academic_year_id')->nullable();
            $table->string('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('feeding_fee_id')->references('id')->on('feeding_fees')->cascadeOnDelete();
            $table->foreign('term_id')->references('id')->on('terms')->cascadeOnDelete();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete();
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_fee_collections');
    }
};
