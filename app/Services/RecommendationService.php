<?php
/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:
This module is part of the MoodMix Web App; provides recommendation services (map feelings to mood quadrants,
list available genres, select songs by mood/genre/year, and fetch album covers via Spotify) used by controllers 
and the UI.

Date Written: July 2025
Date Revised: November 2025

Purpose:
Encapsulates business logic for mood-based music recommendations. Interfaces with Song models to filter tracks, 
categorize emotions, and fetch album artwork through the SpotifyService.

Data structures, algorithms, and control:
- Uses lookup arrays for emotion → quadrant mapping and mood messages.
- Applies dynamic filtering of songs based on genre, year, and mood quadrant.
- Handles fallback logic for genre availability and mood classification.
----------------------------------------------------------------------------------------------------------*/

namespace App\Services;

use App\Models\Song;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * Inject SpotifyService dependency for fetching album images.
     */
    public function __construct(private SpotifyService $spotify)
    {
    }

    /**
     * Retrieve a distinct list of available genres from the Songs table.
     * Falls back to a predefined genre list when DB data is empty or query fails.
     */
    public function availableGenres(): Collection
    {
        try {
            $genres = Song::query()
                ->whereNotNull('genre')
                ->where('genre', '!=', '')
                ->distinct()
                ->orderBy('genre')
                ->pluck('genre');
        } catch (\Throwable $e) {
            // DB error or model issue — return empty, will fall back to defaults below
            $genres = collect();
        }

        // Use predefined fallback genres if database returns nothing
        if ($genres->isEmpty()) {
            $genres = collect([
                'adult alternative', 'adult alternative pop/rock', 'adult contemporary', 'album rock', 
                'alternative dance', 'alternative metal', 'alternative pop/rock', 'alternative rap', 
                'alternative/indie rock', 'am pop', 'americana', 'art rock', 'avant-garde', 'baroque pop', 
                'black gospel', 'blue-eyed soul', 'blues', 'brill building pop', 'british invasion', 
                'british metal', 'british psychedelia', 'british punk', 'britpop', 'cast recordings', 
                'celtic', 'celtic new age', 'celtic rock', "children's", 'christmas', 'classical', 
                'club/dance', 'college rock', 'comedy/spoken', 'contemporary celtic', 
                'contemporary country', 'contemporary jazz', 'contemporary pop/rock', 
                'contemporary r&b', 'contemporary singer/songwriter', 'country', 'country-pop', 
                'country-rock', 'dance-pop', 'dance-rock', 'deep soul', 'disco', 'doom metal', 
                'dream pop', 'early pop/rock', 'east coast rap', 'electronic', 'ethnic fusion', 
                'euro-pop', 'folk', 'folk-rock', 'funk', 'garage rock', 'gospel', 'goth metal', 
                'grunge', 'hard rock', 'hardcore rap', 'heartland rock', 'heavy metal', 'hip-hop', 
                'holidays', 'holiday', 'house', 'industrial', 'industrial dance', 'instrumental pop', 
                'instrumental rock', 'international', 'jazz', 'latin pop', 'lounge', 'mainstream rock', 
                'merseybeat', 'metal', 'midwest rap', 'modern blues', 'modern country', 
                'modern electric blues', 'modern rock', 'motown', 'neo-prog', 'new age', 'new romantic', 
                'new wave', 'northern soul', 'oldies', 'orchestral pop', 'outlaw country', 'pop', 
                'pop/rock', 'pop-soul', 'post-grunge', 'post-punk', 'prog-rock', 'progressive metal', 
                'progressive rock', 'psychedelic', 'psychedelic pop', 'punk', 'punk/new wave', 'r&b', 
                'rap', 'reggae', 'rock & roll', 'roots rock', 'singer/songwriter', 'ska', 'smooth soul', 
                'soft rock', 'soul', 'southern rock', 'speed/thrash metal', 'standards', 'sunshine pop', 
                'swedish pop/rock', 'symphonic rock', 'synth pop', 'teen idols', 'traditional country', 
                'traditional pop', 'urban', 'vocal', 'vocal jazz', 'vocal pop', 'world'
            ]);
        }

        return $genres;
    }

    /**
     * Map a user-provided feeling to its corresponding mood quadrant.
     * Returns fallback mood if primary mapping is unavailable.
     */
    public function feelingToQuadrant(?string $feeling, ?string $fallbackMood): string
    {
        $feeling = strtolower((string) $feeling);

        // Predefined mapping for common emotional states
        $map = [
            'happy' => 'Q1', 'excited' => 'Q1', 'motivated' => 'Q1', 'grateful' => 'Q1', 
            'optimistic' => 'Q1', 'bored' => 'Q1', 'lonely' => 'Q1', 'sad' => 'Q1',

            'angry' => 'Q4', 'stressed' => 'Q4', 'anxious' => 'Q4', 'tired' => 'Q4', 
            'relaxed' => 'Q4', 'peaceful' => 'Q4',
        ];

        // Use direct match if available
        if ($feeling && isset($map[$feeling])) {
            return $map[$feeling];
        }

        // Use fallback mood if provided by caller
        if ($fallbackMood) {
            return $fallbackMood;
        }

        // Default quadrant
        return 'Q1';
    }

    /**
     * Return the human-friendly name of a mood quadrant.
     */
    public function quadrantName(string $quadrant): string
    {
        return [
            'Q1' => 'Happy',
            'Q2' => 'Angry',
            'Q3' => 'Sad',
            'Q4' => 'Relaxed',
        ][$quadrant] ?? $quadrant;
    }

    /**
     * Build a mood message based on feeling when available, otherwise mood category fallback.
     */
    public function moodMessageFor(?string $feeling, string $moodName): string
    {
        $feeling = strtolower((string) $feeling);

        // Personalized messages based on detected feeling
        $feelingMessages = [
            'tired'   => 'Unwind and recharge with these soothing tracks that gently calm your mind and body.',
            'lonely'  => 'Lift your spirits with these joyful songs that bring warmth and connection.',
            'stressed'=> 'Breathe easy—these calming melodies will help release tension and restore balance.',
            'angry'   => 'Find your center with this comforting playlist designed to transform your energy into peace.',
            'sad'     => 'Brighten your mood with these cheerful tunes that paint your day with positivity.',
            'bored'   => 'Spark your motivation and creativity with these energizing beats.',
            'happy'   => 'Share the joy—these vibrant songs amplify and spread your happiness.',
            'relaxed' => 'Stay in the moment—these mellow tunes will keep the calm flowing.',
        ];

        // Fallback for general quadrant-based mood
        $fallback = [
            'Happy'   => 'Here are some uplifting happy songs for you to enlighten up your mood.',
            'Relaxed' => 'Here are some relaxing songs for you to calm down your feelings.',
            'Angry'   => 'Here are some energetic songs to channel that fire in a positive way.',
            'Sad'     => 'Here are some warm, hopeful songs to lift your spirits.',
        ][$moodName] ?? ('Here are some ' . $moodName . ' songs for you');

        return $feelingMessages[$feeling] ?? $fallback;
    }

    /**
     * Normalize and extract selected genres from multiple possible input formats.
     * Supports arrays or delimited strings (commas, pipes, semicolons).
     */
    public function buildSelectedGenres(?array $genres, ?string $genreString): array
    {
        $selected = [];

        // Case 1: genre list provided as array
        if (!empty($genres) && is_array($genres)) {
            $selected = array_filter(array_map('trim', $genres));

        // Case 2: genre list provided as delimited text
        } elseif (!empty($genreString)) {
            $selected = array_filter(
                array_map('trim', preg_split('/[,|;]+/', $genreString))
            );
        }

        return $selected;
    }

    /**
     * Query songs by quadrant and apply optional filters:
     * - Selected genres (partial match, OR-based)
     * - Release year range
     * - Limit results with random ordering for variety
     */
    public function songsFor(string $quadrant, array $selectedGenres, ?int $yearFrom, ?int $yearTo, int $limit)
    {
        $query = Song::where('quadrant', $quadrant);

        // Apply partial genre matching if user selected genres
        if (!empty($selectedGenres)) {
            $query->where(function ($q) use ($selectedGenres) {
                foreach ($selectedGenres as $g) {
                    $q->orWhere('genre', 'like', '%' . $g . '%');
                }
            });
        }

        // Apply year range filtering
        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }

        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }

        // Randomize for better user experience; limit for performance
        return $query->inRandomOrder()->limit($limit)->get();
    }

    /**
     * Fetch album covers for a list of songs using Spotify track IDs.
     * Returns an array keyed by song ID → album cover URL or null on failure.
     */
    public function albumCoversFor($songs): array
    {
        $covers = [];

        foreach ($songs as $song) {
            // Only fetch if track has a valid Spotify URI
            if ($song->spotify_uri) {
                $trackId = str_replace('spotify:track:', '', $song->spotify_uri);

                try {
                    $track = $this->spotify->getTrackById($trackId);
                    $covers[$song->id] = $this->spotify->firstAlbumImageUrl($track);
                } catch (\Throwable $e) {
                    // API error or track not found — return null silently
                    $covers[$song->id] = null;
                }

            } else {
                // No Spotify URI available
                $covers[$song->id] = null;
            }
        }

        return $covers;
    }
}
