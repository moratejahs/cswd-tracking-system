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
        Schema::create('sub_funds', function (Blueprint $table) {
            $table->id();
            $table->string('purpose')->nullable();
            $table->string('amount')->nullable();
            $table->string('personal_reponsible')->nullable();
            $table->foreignId('assistance_id')->nullable()->constrained('assistances')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('client_categories')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_funds');
    }
};
