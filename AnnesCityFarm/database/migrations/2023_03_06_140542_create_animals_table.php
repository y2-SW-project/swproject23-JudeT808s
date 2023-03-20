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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('age');
            $table->string('description');
            //One to Many
            $table->enum('category', ['Goat', 'Pony', 'Sheep', 'Chicken', 'Pig']);
            // $table->unsignedBigInteger('image_id')->nullable();
            $table->foreignId('admin_id')->constrained('admins');
            $table->timestamps();

            //  $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
        });
        Schema::table('images', function (Blueprint $table) {
            $table->unsignedBigInteger('animal_id')->nullable();
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
