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
        Schema::create('schools_packages', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('package_id')->nullable();
            $table->string('package_name')->nullable();
            $table->string('package_amount')->nullable();
            $table->dateTime('package_purchase_date')->nullable();
            $table->string('package_duration')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->string('school_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools_packages');
    }
};
