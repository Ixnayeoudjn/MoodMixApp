<?php

/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:
This module is part of the MoodMix Web App; provides playlist management services (create, list, view details, 
remove songs, delete playlists) used by controllers and the UI. It works closely with the SpotifyService to 
retrieve album images for playlist previews and detailed views.

Date Written: July 2025
Date Revised: November 2025

Purpose:
Encapsulates all playlist-related business logic including creation, lookup, enrichment with mood names, 
and album cover retrieval. Ensures playlist operations remain tied to authenticated users.

Data structures, algorithms, and control:
- Stores playlists per user with mood metadata and optional filters.
- Uses many-to-many relationship with songs for playlist content management.
- Retrieves album cover previews through Spotify API calls.
- Gracefully handles partial failures when Spotify data is unavailable.
----------------------------------------------------------------------------------------------------------*/

namespace App\Services;

use App\Models\Playlist;
use Illuminate\Support\Facades\Auth;

class PlaylistService
{
    /**
     * Inject the SpotifyService dependency to fetch album images for playlists.
     */
    public function __construct(private SpotifyService $spotify)
    {
    }

    /**
     * Convert a quadrant code into a readable mood name.
     * Used when displaying playlists and constructing metadata.
     */
    public function moodName(string $quadrant): string
    {
        return [
            'Q1' => 'Happy',
            'Q2' => 'Angry',
            'Q3' => 'Sad',
            'Q4' => 'Relaxed',
        ][$quadrant] ?? $quadrant;
    }

    /**
     * Create a new playlist for the authenticated user, attach selected songs,
     * and store mood and preference filters.
     */
    public function create(array $data): Playlist
    {
        $playlist = Playlist::create([
            'user_id'   => Auth::id(),
            'name'      => $data['name'],
            'mood'      => $data['mood'],
            'genres'    => $data['genres'] ?? null,
            'year_from' => $data['year_from'] ?? null,
            'year_to'   => $data['year_to'] ?? null,
        ]);

        // Attach songs to playlist (many-to-many relationship)
        $playlist->songs()->attach($data['song_ids']);

        return $playlist;
    }

    /**
     * Retrieve all playlists belonging to the authenticated user.
     * Supports optional name-based search.
     * Enriches each playlist with:
     *   - mood_name (human-readable)
     *   - album_covers (up to 4 covers using Spotify track info)
     */
    public function listForUser(?string $search = null)
    {
        $query = Playlist::where('user_id', Auth::id());

        // Allow searching playlists by name (case-insensitive partial match)
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Preload song count and songs to avoid N+1 queries
        $playlists = $query->withCount('songs')->with('songs')->get();

        // Enhance each playlist with mood name + album cover previews
        $playlists->each(function ($playlist) {

            // Human-readable mood label
            $playlist->mood_name = $this->moodName($playlist->mood);

            $albumCovers = [];

            // Take first 4 songs for preview display
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
                        // Suppress errors for individual failures to avoid breaking the entire list
                    }
                }
            }

            $playlist->album_covers = $albumCovers;
        });

        return $playlists;
    }

    /**
     * Return the playlist with fully loaded songs and album covers for all items.
     * Used for full playlist view or detailed screen.
     *
     * Returns an array: [playlist, album_covers]
     */
    public function details(Playlist $playlist): array
    {
        // Load songs to avoid lazy-loading on iteration
        $playlist->load('songs');

        // Attach human-readable mood name
        $playlist->mood_name = $this->moodName($playlist->mood);

        $albumCovers = [];

        // Fetch album cover for every song, not just the first 4 (unlike list view)
        foreach ($playlist->songs as $song) {
            if ($song->spotify_uri) {

                $trackId = str_replace('spotify:track:', '', $song->spotify_uri);

                try {
                    $track = $this->spotify->getTrackById($trackId);
                    $albumCovers[$song->id] = $this->spotify->firstAlbumImageUrl($track);
                } catch (\Throwable $e) {
                    // Track lookup failed — store null to maintain array integrity
                    $albumCovers[$song->id] = null;
                }

            } else {
                // No Spotify URI available — cannot fetch cover
                $albumCovers[$song->id] = null;
            }
        }

        return [$playlist, $albumCovers];
    }

    /**
     * Remove a song from a playlist (many-to-many detach).
     */
    public function removeSong(Playlist $playlist, int $songId): void
    {
        $playlist->songs()->detach($songId);
    }

    /**
     * Delete a playlist owned by the user including all relational attachments.
     * Songs remain in the DB; only pivot entries are removed.
     */
    public function delete(Playlist $playlist): void
    {
        // Detach all song relationships
        $playlist->songs()->detach();

        // Delete playlist record
        $playlist->delete();
    }
}
