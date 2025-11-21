<?php

/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:
This module is part of the MoodMix Web Application that allows users to create, view, and manage 
playlists based on their moods and preferences. It contains different functions that handles different requests
related to playlist management, such as creating a new playlist, viewing existing playlists, displaying
details of a specific playlist, removing songs from a playlist, and deleting an entire playlist.     

Date Written: July 2025
Date Revised: November 2025

Purpose: 
This controller coordinates HTTP request handling for user playlists. It:
- Validates incoming request data.
- Ensures user authorization for playlist operations.
- Delegates business logic to PlaylistService (creation, deletion, retrieval, and song removal).
- Returns appropriate HTTP responses and redirects for UI flows.

Data structures, algorithms, and control:
- Playlist: Eloquent model representing a user playlist (hasMany songs / belongsTo user relationships).
- Arrays: used for passing lists (song IDs, genres) between controller and service.
- Scalars: strings/integers for fields like name, mood, and year range.
- Input validation using Laravel's Request::validate for required fields, types, and constraints.
- Authorization checks comparing playlist.user_id with the authenticated user id to guard access.
- Delegation pattern: controller delegates complex operations to PlaylistService to keep controller thin.
- Error handling: try/catch around destructive operations returning JSON error codes where appropriate.

----------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;
use App\Services\PlaylistService;

class PlaylistController extends Controller
{
    // Dependency-injected PlaylistService: handles the business logic so controller stays thin.
    public function __construct(private PlaylistService $playlists)
    {
    }

    // Store a newly created playlist. Validates input, delegates creation to the service, then redirects.
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

        // Delegate creation and persistence to PlaylistService which encapsulates the creation logic.
        $this->playlists->create($request->only(['name', 'mood', 'genres', 'year_from', 'year_to', 'song_ids']));

        // Redirect back to playlist index with a success flash message.
        return redirect()->route('playlist.index')->with('success', 'Playlist saved!');
    }

    // Display a list of playlists for the authenticated user, optionally filtered by a search term.
    public function index(Request $request)
    {
        // Normalize search input: use null when empty so the service can handle it consistently.
        $search = $request->has('search') && !empty($request->search) ? $request->search : null;

        // Delegate retrieval to the service (handles scoping to current user and search/filter logic).
        $playlists = $this->playlists->listForUser($search);
        return view('library.index', compact('playlists'));
    }

    // Show details for a single playlist. Includes an authorization check and requests additional details from the service.
    public function show(Playlist $playlist)
    {
        // Ensure the current user owns the playlist before showing details.
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Service returns the playlist with eager-loaded relations and an array of album cover URLs.
        [$playlist, $albumCovers] = $this->playlists->details($playlist);
        return view('library.show', compact('playlist', 'albumCovers'));
    }

    /**
     * Remove a song from a playlist
     */
    public function removeSong(Request $request, Playlist $playlist)
    {
        // Ensure the current user owns the playlist before modifying it.
        if ($playlist->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Validate that a valid song_id is provided and exists in the songs table.
        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        try {
            // Delegate removal to the service which will update relations and persist changes.
            $this->playlists->removeSong($playlist, (int) $request->song_id);
            return response()->json([
                'success' => true,
                'message' => 'Song removed successfully'
            ]);
        } catch (\Throwable $e) {
            // Loggable error path: return a generic error message and 500 status to the client.
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
        // Authorization: only the owner may delete the playlist.
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Delegate permanent deletion to the service which handles cascade/dependencies.
        $this->playlists->delete($playlist);
        return redirect()->route('playlist.index')->with('success', 'Playlist deleted successfully!');
    }
}
