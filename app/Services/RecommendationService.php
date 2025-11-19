<?php

namespace App\Services;

use App\Models\Song;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function __construct(private SpotifyService $spotify)
    {
    }

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
            $genres = collect();
        }

        if ($genres->isEmpty()) {
            $genres = collect([
                'adult alternative', 'adult alternative pop/rock', 'adult contemporary', 'album rock', 'alternative dance', 'alternative metal', 'alternative pop/rock', 'alternative rap', 'alternative/indie rock', 'am pop', 'americana', 'art rock', 'avant-garde', 'baroque pop', 'black gospel', 'blue-eyed soul', 'blues', 'brill building pop', 'british invasion', 'british metal', 'british psychedelia', 'british punk', 'britpop', 'cast recordings', 'celtic', 'celtic new age', 'celtic rock', "children's", 'christmas', 'classical', 'club/dance', 'college rock', 'comedy/spoken', 'contemporary celtic', 'contemporary country', 'contemporary jazz', 'contemporary pop/rock', 'contemporary r&b', 'contemporary singer/songwriter', 'country', 'country-pop', 'country-rock', 'dance-pop', 'dance-rock', 'deep soul', 'disco', 'doom metal', 'dream pop', 'early pop/rock', 'east coast rap', 'electronic', 'ethnic fusion', 'euro-pop', 'folk', 'folk-rock', 'funk', 'garage rock', 'gospel', 'goth metal', 'grunge', 'hard rock', 'hardcore rap', 'heartland rock', 'heavy metal', 'hip-hop', 'holidays', 'holiday', 'house', 'industrial', 'industrial dance', 'instrumental pop', 'instrumental rock', 'international', 'jazz', 'latin pop', 'lounge', 'mainstream rock', 'merseybeat', 'metal', 'midwest rap', 'modern blues', 'modern country', 'modern electric blues', 'modern rock', 'motown', 'neo-prog', 'new age', 'new romantic', 'new wave', 'northern soul', 'oldies', 'orchestral pop', 'outlaw country', 'pop', 'pop/rock', 'pop-soul', 'post-grunge', 'post-punk', 'prog-rock', 'progressive metal', 'progressive rock', 'psychedelic', 'psychedelic pop', 'punk', 'punk/new wave', 'r&b', 'rap', 'reggae', 'rock & roll', 'roots rock', 'singer/songwriter', 'ska', 'smooth soul', 'soft rock', 'soul', 'southern rock', 'speed/thrash metal', 'standards', 'sunshine pop', 'swedish pop/rock', 'symphonic rock', 'synth pop', 'teen idols', 'traditional country', 'traditional pop', 'urban', 'vocal', 'vocal jazz', 'vocal pop', 'world'
            ]);
        }

        return $genres;
    }

    public function feelingToQuadrant(?string $feeling, ?string $fallbackMood): string
    {
        $feeling = strtolower((string) $feeling);
        $map = [
            'happy' => 'Q1', 'excited' => 'Q1', 'motivated' => 'Q1', 'grateful' => 'Q1', 'optimistic' => 'Q1',
            'bored' => 'Q1', 'lonely' => 'Q1', 'sad' => 'Q1',
            'angry' => 'Q4', 'stressed' => 'Q4', 'anxious' => 'Q4', 'tired' => 'Q4', 'relaxed' => 'Q4', 'peaceful' => 'Q4',
        ];

        if ($feeling && isset($map[$feeling])) {
            return $map[$feeling];
        }

        if ($fallbackMood) {
            return $fallbackMood;
        }

        return 'Q1';
    }

    public function quadrantName(string $quadrant): string
    {
        return [
            'Q1' => 'Happy',
            'Q2' => 'Angry',
            'Q3' => 'Sad',
            'Q4' => 'Relaxed',
        ][$quadrant] ?? $quadrant;
    }

    public function moodMessageFor(?string $feeling, string $moodName): string
    {
        $feeling = strtolower((string) $feeling);

        $feelingMessages = [
            'tired' => 'Unwind and recharge with these soothing tracks that gently calm your mind and body.',
            'lonely' => 'Lift your spirits with these joyful songs that bring warmth and connection.',
            'stressed' => 'Breathe easy—these calming melodies will help release tension and restore balance.',
            'angry' => 'Find your center with this comforting playlist designed to transform your energy into peace.',
            'sad' => 'Brighten your mood with these cheerful tunes that paint your day with positivity.',
            'bored' => 'Spark your motivation and creativity with these energizing beats.',
            'happy' => 'Share the joy—these vibrant songs amplify and spread your happiness.',
            'relaxed' => 'Stay in the moment—these mellow tunes will keep the calm flowing.',
        ];

        $fallback = [
            'Happy' => 'Here are some uplifting happy songs for you to enlighten up your mood.',
            'Relaxed' => 'Here are some relaxing songs for you to calm down your feelings.',
            'Angry' => 'Here are some energetic songs to channel that fire in a positive way.',
            'Sad' => 'Here are some warm, hopeful songs to lift your spirits.',
        ][$moodName] ?? ('Here are some ' . $moodName . ' songs for you');

        return $feelingMessages[$feeling] ?? $fallback;
    }

    public function buildSelectedGenres(?array $genres, ?string $genreString): array
    {
        $selected = [];
        if (!empty($genres) && is_array($genres)) {
            $selected = array_filter(array_map('trim', $genres));
        } elseif (!empty($genreString)) {
            $selected = array_filter(array_map('trim', preg_split('/[,|;]+/', $genreString)));
        }
        return $selected;
    }

    public function songsFor(string $quadrant, array $selectedGenres, ?int $yearFrom, ?int $yearTo, int $limit)
    {
        $query = Song::where('quadrant', $quadrant);

        if (!empty($selectedGenres)) {
            $query->where(function ($q) use ($selectedGenres) {
                foreach ($selectedGenres as $g) {
                    $q->orWhere('genre', 'like', '%' . $g . '%');
                }
            });
        }

        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }

        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }

        return $query->inRandomOrder()->limit($limit)->get();
    }

    public function albumCoversFor($songs): array
    {
        $covers = [];
        foreach ($songs as $song) {
            if ($song->spotify_uri) {
                $trackId = str_replace('spotify:track:', '', $song->spotify_uri);
                try {
                    $track = $this->spotify->getTrackById($trackId);
                    $covers[$song->id] = $this->spotify->firstAlbumImageUrl($track);
                } catch (\Throwable $e) {
                    $covers[$song->id] = null;
                }
            } else {
                $covers[$song->id] = null;
            }
        }
        return $covers;
    }
}
