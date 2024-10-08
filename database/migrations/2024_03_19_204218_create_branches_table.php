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
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('branch_name');
            $table->string('branch_description')->nullable();
            $table->string('branch_location');
            $table->string('branch_email')->nullable();
            $table->string('branch_contact')->nullable();
            $table->tinyInteger('is_active')->default('1');
             $table->string('school_id')->nullable();
            // $table->foreign('school_id')->references('school_id')->on('schools')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
