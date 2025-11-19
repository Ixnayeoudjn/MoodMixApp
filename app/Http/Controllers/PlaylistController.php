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

Data structures, algorithms, and control:

----------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Playlist;
use App\Services\PlaylistService;

class PlaylistController extends Controller
{
    public function __construct(private PlaylistService $playlists)
    {
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

        $this->playlists->create($request->only(['name', 'mood', 'genres', 'year_from', 'year_to', 'song_ids']));

        return redirect()->route('playlist.index')->with('success', 'Playlist saved!');
    }

    public function index(Request $request)
    {
        $search = $request->has('search') && !empty($request->search) ? $request->search : null;
        $playlists = $this->playlists->listForUser($search);
        return view('library.index', compact('playlists'));
    }

    public function show(Playlist $playlist)
    {
        if ($playlist->user_id !== Auth::id()) {
            abort(403);
        }

        [$playlist, $albumCovers] = $this->playlists->details($playlist);
        return view('library.show', compact('playlist', 'albumCovers'));
    }

    /**
     * Remove a song from a playlist
     */
    public function removeSong(Request $request, Playlist $playlist)
    {
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
            $this->playlists->removeSong($playlist, (int) $request->song_id);
            return response()->json([
                'success' => true,
                'message' => 'Song removed successfully'
            ]);
        } catch (\Throwable $e) {
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

        $this->playlists->delete($playlist);
        return redirect()->route('playlist.index')->with('success', 'Playlist deleted successfully!');
    }
}
