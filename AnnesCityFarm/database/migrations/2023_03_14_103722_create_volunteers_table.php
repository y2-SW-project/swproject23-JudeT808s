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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('age');
            $table->string('phoneNo');
            //One to Many
            $table->enum('Availability', ['Saturday 9-3', 'Saturday 3-6', 'Sunday 9-3', 'Sunday 3-6'] );
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};