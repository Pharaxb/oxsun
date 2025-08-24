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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('file');
            $table->enum('file_type', ['P', 'V'])->default('P');
            $table->unsignedInteger('circulation');
            $table->unsignedInteger('viewed')->default('0');
            $table->unsignedInteger('cost');
            $table->unsignedInteger('commission')->nullable();
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->unsignedBigInteger('min_age_id')->nullable();
            $table->unsignedBigInteger('max_age_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->boolean('is_verify')->default(false);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->text('comment')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
