<?php

/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:

Date Written: July 2025
Date Revised: November 2025

Purpose: 

Data structures, algorithms, and control:

----------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;

class RecommendationController extends Controller
{
    public function __construct(private RecommendationService $recs)
    {
    }

    public function form()
    {
        $genres = $this->recs->availableGenres();
        return view('recommendation.form', compact('genres'));
    }

    public function results(Request $request)
    {
        $request->validate([
            'feeling' => 'nullable|string|in:happy,angry,sad,relaxed,tired,lonely,anxious,stressed,bored,excited,motivated,peaceful,grateful,optimistic',
            'mood' => 'nullable|in:Q1,Q2,Q3,Q4',
            'genres' => 'nullable|array',
            'genre' => 'nullable|string',
            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',
            'song_count' => 'required|integer|min:1|max:100',
        ]);

        if (!$request->filled('feeling') && !$request->filled('mood')) {
            return back()->withErrors(['feeling' => 'Please tell us how you feel or choose a mood.']);
        }

        $feeling = $request->input('feeling');
        $targetQuadrant = $this->recs->feelingToQuadrant($feeling, $request->input('mood'));
        $moodName = $this->recs->quadrantName($targetQuadrant);
        $moodMessage = $this->recs->moodMessageFor($feeling, $moodName);

        $selectedGenres = $this->recs->buildSelectedGenres($request->input('genres'), $request->input('genre'));
        $limit = (int) $request->input('song_count', 20);

        $songs = $this->recs->songsFor(
            $targetQuadrant,
            $selectedGenres,
            $request->input('year_from'),
            $request->input('year_to'),
            $limit
        );

        $albumCovers = $this->recs->albumCoversFor($songs);

        $filters = array_merge(
            $request->only(['year_from', 'year_to', 'song_count']),
            [
                'mood' => $targetQuadrant,
                'mood_name' => $moodName,
                'mood_message' => $moodMessage,
                'feeling' => $feeling ?: null,
                'genres' => $selectedGenres
            ]
        );

        return view('recommendation.results', compact('songs', 'filters', 'albumCovers'));
    }

    public function removeSong(Request $request)
    {
        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Song removed successfully'
        ]);
    }
}
