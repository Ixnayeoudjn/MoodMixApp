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
        Schema::create('playlist_song', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')
                  ->constrained('playlists')
                  ->onDelete('cascade');
            $table->foreignId('song_id')
                  ->constrained('songs')
                  ->onDelete('cascade');

            // If you want to preserve a specific order in the playlist:
            // $table->unsignedInteger('position')->nullable();

            $table->timestamps();
            
            // prevent duplicate song entries
            $table->unique(['playlist_id','song_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playlist_songs');
    }
};
