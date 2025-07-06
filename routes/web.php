<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/recommend', [RecommendationController::class, 'form'])->name('recommendation.form');
    Route::get('/recommend/results', [RecommendationController::class, 'results'])->name('recommendation.results');
    Route::post('/recommend/remove-song', [RecommendationController::class, 'removeSong'])->name('recommend.removeSong');

    Route::post('/playlist/save', [PlaylistController::class, 'store'])->name('playlist.save');
    Route::get('/library', [PlaylistController::class, 'index'])->name('playlist.index');
    Route::get('/library/{playlist}', [PlaylistController::class, 'show'])->name('playlist.show');
    Route::post('/playlist/{playlist}/remove-song', [PlaylistController::class, 'removeSong'])->name('playlist.removeSong');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/spotify/auth', [SpotifyController::class, 'redirectToSpotify'])->name('spotify.auth');
    Route::get('/spotify/callback', [SpotifyController::class, 'handleCallback']);
    Route::post('/spotify/export/{playlist}', [SpotifyController::class, 'export'])->name('spotify.export');

    Route::resource('playlist', PlaylistController::class);
});


require __DIR__.'/auth.php';
