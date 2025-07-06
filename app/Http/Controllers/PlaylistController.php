<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;
use App\Models\Song;

class PlaylistController extends Controller
{
    /**
     * Map quadrant codes to human-readable mood names
     */
    private function getMoodName($quadrant)
    {
        $moodMap = [
            'Q1' => 'Happy',
            'Q2' => 'Angry',
            'Q3' => 'Sad',
            'Q4' => 'Relaxed'
        ];

        return $moodMap[$quadrant] ?? $quadrant;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mood' => 'required|in:Q1,Q2,Q3,Q4',
            'genres' => 'nullable|array',
            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',
            'song_ids' => 'required|array',
        ]);

        $playlist = Playlist::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'mood' => $request->mood,
            'genres' => $request->genres,
            'year_from' => $request->year_from,
            'year_to' => $request->year_to,
        ]);

        $playlist->songs()->attach($request->song_ids);

        return redirect()->route('playlist.index')->with('success', 'Playlist saved!');
    }

    public function index()
    {
        $playlists = Playlist::where('user_id', Auth::id())->withCount('songs')->get();
        
        // Map mood codes to readable names for display
        $playlists->each(function ($playlist) {
            $playlist->mood_name = $this->getMoodName($playlist->mood);
        });
        
        return view('library.index', compact('playlists'));
    }

    public function show(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        $playlist->load('songs');

        // Map mood code to readable name
        $playlist->mood_name = $this->getMoodName($playlist->mood);

        // --- Spotify API: Client Credentials Flow ---
        $session = new \SpotifyWebAPI\Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET')
        );

        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $spotify = new \SpotifyWebAPI\SpotifyWebAPI();
        $spotify->setAccessToken($accessToken);

        $albumCovers = [];

        foreach ($playlist->songs as $song) {
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

        return view('library.show', compact('playlist', 'albumCovers'));
    }

    /**
     * Remove a song from a playlist
     */
    public function removeSong(Request $request, Playlist $playlist)
    {
        // Check if the user owns this playlist
        if ($playlist->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        try {
            // Remove the song from the playlist
            $playlist->songs()->detach($request->song_id);
            
            return response()->json([
                'success' => true,
                'message' => 'Song removed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing song'
            ], 500);
        }
    }

    /**
     * Delete an entire playlist
     */
    public function destroy(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Detach songs first (optional)
        $playlist->songs()->detach();

        // Delete playlist
        $playlist->delete();

        return redirect()->route('playlist.index')->with('success', 'Playlist deleted successfully!');
    }
}
