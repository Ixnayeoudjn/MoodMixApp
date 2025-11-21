<?php

/*---------------------------------------------------------------------------------------------------------
Program Title: Playlist Management Module

Programmers:    Marzan, Kristina Amor A.
                Millano, Ryan Kris F.
                Narisma, Anaise Nicole M.
                Seño, Lei Hant L.

Where the program fits in the general system designs:
This controller provides the front-end endpoints for generating song recommendations
based on user feelings, mood quadrants, and genre/year filters. It bridges UI forms
and the RecommendationService which encapsulates recommendation logic.

Date Written: July 2025
Date Revised: November 2025

Purpose: 
- Present a recommendations form to the user and process the results request.
- Validate user inputs and convert feelings to application-specific mood quadrants.
- Assemble filters and delegate actual song selection to RecommendationService.
- Return rendered views with songs and metadata for display.

Data structures, algorithms, and control:
- Arrays: used for lists of genres, selected filters, and song collections.
- Scalars: strings/integers for feelings, mood quadrants, year ranges and counts.
- Input validation via Laravel's Request::validate to enforce types and constraints.
- Mapping algorithm: feelingToQuadrant converts free-text feeling to one of four quadrants.
- Composition: buildSelectedGenres merges explicit genre choices with multi-select arrays.
- Delegation: songsFor and albumCoversFor encapsulate recommendation and media fetching.
- Guard clauses: ensure either feeling or mood is provided before proceeding.

----------------------------------------------------------------------------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecommendationService;

class RecommendationController extends Controller
{
    // Inject RecommendationService to offload scoring/filtering and data access.
    public function __construct(private RecommendationService $recs)
    {
    }

    // Show the recommendation form with available genres.
    public function form()
    {
        // Fetch list of genres from service for form population.
        $genres = $this->recs->availableGenres();
        return view('recommendation.form', compact('genres'));
    }

    // Process recommendation requests: validate, map feeling->quadrant, fetch songs and album covers.
    public function results(Request $request)
    {
        $request->validate([
            'feeling' => 'nullable|string|in:happy,angry,sad,relaxed,tired,
                          lonely,anxious,stressed,bored,excited,motivated,
                          peaceful,grateful,optimistic',
            'mood' => 'nullable|in:Q1,Q2,Q3,Q4',
            'genres' => 'nullable|array',
            'genre' => 'nullable|string',
            'year_from' => 'nullable|integer',
            'year_to' => 'nullable|integer',
            'song_count' => 'required|integer|min:1|max:100',
        ]);

        // Require at least a feeling or a mood selection to generate recommendations.
        if (!$request->filled('feeling') && !$request->filled('mood')) {
            return back()->withErrors(['feeling' => 'Please tell us how you feel or choose a mood.']);
        }

        // Normalize inputs and derive the target quadrant for recommendations.
        $feeling = $request->input('feeling');
        $targetQuadrant = $this->recs->feelingToQuadrant($feeling, $request->input('mood'));
        $moodName = $this->recs->quadrantName($targetQuadrant);
        $moodMessage = $this->recs->moodMessageFor($feeling, $moodName);

        // Consolidate selected genres from multi-select and single-select inputs.
        $selectedGenres = $this->recs->buildSelectedGenres($request->input('genres'), $request->input('genre'));
        $limit = (int) $request->input('song_count', 20);

        // Delegate song selection to service applying quadrant, genres, year filters and limit.
        $songs = $this->recs->songsFor(
            $targetQuadrant,
            $selectedGenres,
            $request->input('year_from'),
            $request->input('year_to'),
            $limit
        );

        // Prepare album cover images for display (service handles caching/lookup).
        $albumCovers = $this->recs->albumCoversFor($songs);

        // Build filters array to keep the UI state and display contextual messages.
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

    // Remove a song from the temporary recommendation list (client-side convenience endpoint).
    public function removeSong(Request $request)
    {
        // Validate song id before acknowledging removal. Actual state is typically client-side.
        $request->validate([
            'song_id' => 'required|exists:songs,id'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Song removed successfully'
        ]);
    }
}
