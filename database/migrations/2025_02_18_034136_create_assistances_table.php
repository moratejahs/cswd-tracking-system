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
        Schema::create('assistances', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->dateTime('birth_date');
            $table->string('address');
            $table->string('contact_no');
            $table->string('status');
            $table->string('occupation');
            $table->string('assistance');
            $table->integer('quantity');
            $table->string('person_of_responsible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistances');
    }
};
