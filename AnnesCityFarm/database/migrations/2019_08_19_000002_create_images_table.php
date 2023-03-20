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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            //Detects file format
            $table->string('type');
            $table->string('path');
            $table->unsignedBigInteger('imageable_id');
            //This will determine whether is for article or animal
            $table->string('imageable_type');
            $table->timestamps();
            $table->index(['imageable_id', 'imageable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};