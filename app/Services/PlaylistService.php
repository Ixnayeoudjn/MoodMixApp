<?php

namespace App\Services;

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;

class PlaylistService
{
    public function __construct(private SpotifyService $spotify)
    {
    }

    public function moodName(string $quadrant): string
    {
        return [
            'Q1' => 'Happy',
            'Q2' => 'Angry',
            'Q3' => 'Sad',
            'Q4' => 'Relaxed',
        ][$quadrant] ?? $quadrant;
    }

    public function create(array $data): Playlist
    {
        $playlist = Playlist::create([
            'user_id' => Auth::id(),
            'name' => $data['name'],
            'mood' => $data['mood'],
            'genres' => $data['genres'] ?? null,
            'year_from' => $data['year_from'] ?? null,
            'year_to' => $data['year_to'] ?? null,
        ]);

        $playlist->songs()->attach($data['song_ids']);
        return $playlist;
    }

    public function listForUser(?string $search = null)
    {
        $query = Playlist::where('user_id', Auth::id());

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $playlists = $query->withCount('songs')->with('songs')->get();

        // Enrich with mood name and album covers via Spotify
        $playlists->each(function ($playlist) {
            $playlist->mood_name = $this->moodName($playlist->mood);

            $albumCovers = [];
            foreach ($playlist->songs->take(4) as $song) {
                if ($song->spotify_uri) {
                    $trackId = str_replace('spotify:track:', '', $song->spotify_uri);
                    try {
                        $track = $this->spotify->getTrackById($trackId);
                        $cover = $this->spotify->firstAlbumImageUrl($track);
                        if ($cover) {
                            $albumCovers[] = $cover;
                        }
                    } catch (\Throwable $e) {
                        // ignore individual failures
                    }
                }
            }
            $playlist->album_covers = $albumCovers;
        });

        return $playlists;
    }

    public function details(Playlist $playlist): array
    {
        $playlist->load('songs');
        $playlist->mood_name = $this->moodName($playlist->mood);

        $albumCovers = [];
        foreach ($playlist->songs as $song) {
            if ($song->spotify_uri) {
                $trackId = str_replace('spotify:track:', '', $song->spotify_uri);
                try {
                    $track = $this->spotify->getTrackById($trackId);
                    $albumCovers[$song->id] = $this->spotify->firstAlbumImageUrl($track);
                } catch (\Throwable $e) {
                    $albumCovers[$song->id] = null;
                }
            } else {
                $albumCovers[$song->id] = null;
            }
        }

        return [$playlist, $albumCovers];
    }

    public function removeSong(Playlist $playlist, int $songId): void
    {
        $playlist->songs()->detach($songId);
    }

    public function delete(Playlist $playlist): void
    {
        $playlist->songs()->detach();
        $playlist->delete();
    }
}
