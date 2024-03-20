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
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('school_id');
            $table->string('school_name');
            $table->string('school_location')->nullable();
            $table->string('school_email')->unique();
            $table->string('school_phoneNumber');
            $table->string('school_logo')->nullable();
            $table->string('admin_id')->nullable();
            // $table->string('branch_id')->nullable();
            // $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
            // $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
