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
        // Pull distinct genres from the songs table, fallback to a predefined list if empty
        try {
            $genres = Song::query()
                ->whereNotNull('genre')
                ->where('genre', '!=', '')
                ->distinct()
                ->orderBy('genre')
                ->pluck('genre');
        } catch (\Throwable $e) {
            // In case the DB isn't available yet
            $genres = collect();
        }

        if ($genres->isEmpty()) {
            $genres = collect([
                'adult alternative', 'adult alternative pop/rock', 'adult contemporary', 'album rock', 'alternative dance', 'alternative metal', 'alternative pop/rock', 'alternative rap', 'alternative/indie rock', 'am pop', 'americana', 'art rock', 'avant-garde', 'baroque pop', 'black gospel', 'blue-eyed soul', 'blues', 'brill building pop', 'british invasion', 'british metal', 'british psychedelia', 'british punk', 'britpop', 'cast recordings', 'celtic', 'celtic new age', 'celtic rock', "children's", 'christmas', 'classical', 'club/dance', 'college rock', 'comedy/spoken', 'contemporary celtic', 'contemporary country', 'contemporary jazz', 'contemporary pop/rock', 'contemporary r&b', 'contemporary singer/songwriter', 'country', 'country-pop', 'country-rock', 'dance-pop', 'dance-rock', 'deep soul', 'disco', 'doom metal', 'dream pop', 'early pop/rock', 'east coast rap', 'electronic', 'ethnic fusion', 'euro-pop', 'folk', 'folk-rock', 'funk', 'garage rock', 'gospel', 'goth metal', 'grunge', 'hard rock', 'hardcore rap', 'heartland rock', 'heavy metal', 'hip-hop', 'holidays', 'holiday', 'house', 'industrial', 'industrial dance', 'instrumental pop', 'instrumental rock', 'international', 'jazz', 'latin pop', 'lounge', 'mainstream rock', 'merseybeat', 'metal', 'midwest rap', 'modern blues', 'modern country', 'modern electric blues', 'modern rock', 'motown', 'neo-prog', 'new age', 'new romantic', 'new wave', 'northern soul', 'oldies', 'orchestral pop', 'outlaw country', 'pop', 'pop/rock', 'pop-soul', 'post-grunge', 'post-punk', 'prog-rock', 'progressive metal', 'progressive rock', 'psychedelic', 'psychedelic pop', 'punk', 'punk/new wave', 'r&b', 'rap', 'reggae', 'rock & roll', 'roots rock', 'singer/songwriter', 'ska', 'smooth soul', 'soft rock', 'soul', 'southern rock', 'speed/thrash metal', 'standards', 'sunshine pop', 'swedish pop/rock', 'symphonic rock', 'synth pop', 'teen idols', 'traditional country', 'traditional pop', 'urban', 'vocal', 'vocal jazz', 'vocal pop', 'world'
            ]);
        }

        return view('recommendation.form', compact('genres'));
    }

    public function results(Request $request)
    {
        $request->validate([
            'mood' => 'required|in:Q1,Q2,Q3,Q4',
            'genres' => 'nullable|array',
            'genre' => 'nullable|string',
            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',
            'song_count' => 'required|integer|min:1|max:100',
        ]);

        $query = Song::where('quadrant', $request->mood);

        // Build a normalized list of selected genres from either 'genres' (array) or 'genre' (string)
        $selectedGenres = [];
        if ($request->filled('genres') && is_array($request->genres)) {
            $selectedGenres = array_filter(array_map('trim', $request->genres));
        } elseif ($request->filled('genre')) {
            $selectedGenres = array_filter(array_map('trim', preg_split('/[,|;]+/', $request->input('genre'))));
        }

        if (!empty($selectedGenres)) {
            $query->where(function ($q) use ($selectedGenres) {
                foreach ($selectedGenres as $genre) {
                    $q->orWhere('genre', 'like', '%' . $genre . '%');
                }
            });
        }

        if ($request->year_from) {
            $query->where('year', '>=', $request->year_from);
        }

        if ($request->year_to) {
            $query->where('year', '<=', $request->year_to);
        }

        $limit = $request->input('song_count', 20); // Default to 20 if not specified

        $songs = $query->inRandomOrder()->limit($limit)->get();

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

        $filters = array_merge(
            $request->only(['mood', 'year_from', 'year_to', 'song_count']),
            ['genres' => $selectedGenres]
        );

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
