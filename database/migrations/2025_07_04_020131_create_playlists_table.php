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
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()            // assumes users.id
                  ->onDelete('cascade');     // delete playlists when user is removed

            $table->string('name');        // user‑given playlist name
            $table->enum('mood', ['Q1','Q2','Q3','Q4']);
            $table->json('genres')->nullable();   // optional: ["rock","pop",…]
            $table->unsignedSmallInteger('year_from')->nullable();
            $table->unsignedSmallInteger('year_to')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlists');
    }
};
