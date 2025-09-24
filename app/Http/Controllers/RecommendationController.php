<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;

class RecommendationController extends Controller
{
    public function form()
    {
        return view('recommendation.form');
    }

    public function results(Request $request)
    {
        $request->validate([
            'mood' => 'required|in:Q1,Q2,Q3,Q4',
            'genres' => 'array',
            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',
        ]);

        $query = Song::where('quadrant', $request->mood);

        if ($request->filled('genres')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genres as $genre) {
                    $q->orWhere('genre', 'like', "%{$genre}%");
                }
            });
        }

        if ($request->year_from) {
            $query->where('year', '>=', $request->year_from);
        }

        if ($request->year_to) {
            $query->where('year', '<=', $request->year_to);
        }

        $songs = $query->inRandomOrder()->limit(100)->get();

        // --- Spotify API: Client Credentials Flow ---
        $session = new Session(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret'),
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $spotify = new SpotifyWebAPI();
        $spotify->setAccessToken($accessToken);

        $albumCovers = [];

        foreach ($songs as $song) {
            if ($song->spotify_uri) {
                $trackId = str_replace('spotify:track:', '', $song->spotify_uri);

                try {
                    $track = $spotify->getTrack($trackId);
                    $albumCovers[$song->id] = $track->album->images[0]->url ?? null;
                } catch (\Exception $e) {
                    $albumCovers[$song->id] = null;
                }
            } else {
                $albumCovers[$song->id] = null;
            }
        }

        $filters = $request->only(['mood', 'genres', 'year_from', 'year_to']);

        return view('recommendation.results', compact('songs', 'filters', 'albumCovers'));
    }

    /**
     * Remove a song from the current recommendation session (optional AJAX endpoint)
     * This method can be used if you want to implement server-side song removal
     */
    public function removeSong(Request $request)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        // Since we're working with a session-based recommendation system,
        // we'll return a success response. The actual removal is handled
        // client-side in the current implementation.
        
        return response()->json([
            'success' => true,
            'message' => 'Song removed successfully'
        ]);
    }
}
