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
        Schema::create('barangay_assitances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistance_id');
            $table->unsignedBigInteger('barangay_id');
            $table->enum('status', ['pending', 'processing', 'done', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangay_assitances');
    }
};