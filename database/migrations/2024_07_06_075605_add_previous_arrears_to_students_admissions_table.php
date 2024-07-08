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
        Schema::table('students_admissions', function (Blueprint $table) {
            $table->float('previous_arrears')->default('0');
            $table->float('current_bill_amount')->default('0');
            $table->float('total_bill_amount')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students_admissions', function (Blueprint $table) {
            //
        });
    }
};
