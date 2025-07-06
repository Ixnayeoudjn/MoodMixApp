<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'mood',
        'genres',
        'year_from',
        'year_to',
    ];
    
    protected $casts = [
        'genres' => 'array',
        'year_from' => 'integer',
        'year_to' => 'integer',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function songs() { return $this->belongsToMany(Song::class, 'playlist_song'); }
}

// app/Models/Song.php
class Song extends Model
{
    public function playlists() { return $this->belongsToMany(Playlist::class, 'playlist_song'); }
}
