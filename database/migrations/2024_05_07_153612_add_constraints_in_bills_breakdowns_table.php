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
        Schema::table('bills_breakdowns', function (Blueprint $table) {
           $table->foreign('bill_id')->references('id')->on('bills')->cascadeOnDelete();
           $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
           $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills_breakdowns', function (Blueprint $table) {
            $table->string('bill_id');
            $table->string('school_id');
            $table->string('branch_id');
        });
    }
};
