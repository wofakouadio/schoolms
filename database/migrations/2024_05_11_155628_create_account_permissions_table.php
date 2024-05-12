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
        Schema::create('account_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique()->index();
            $table->string('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('school_id')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('user_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_permissions');
    }
};
