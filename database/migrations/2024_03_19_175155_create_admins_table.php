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
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();;
            $table->string('admin_firstName');
            $table->string('admin_lastName');
            $table->string('admin_phoneNumber');
            $table->string('admin_email')->unique();
            $table->string('admin_password');
            $table->tinyInteger('is_active')->default('0');
            $table->string('school_id')->nullable();
            $table->string('branch_id')->nullable();
            // $table->foreign('school_id')->references('school_id')->on('schools')->onDelete('cascade');
            // $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
