<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoodMix - Your Mood, Your Music</title>
    @vite(['resources/css/welcome.css'])
</head>
<body>
    <!-- Header Navigation -->
    <header class="header fade-in-up">
        <div class="logo-section">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" class="logo-img">
            <a href="{{ url('/') }}" class="logo-text">MoodMix</a>
        </div>
        @auth
            <nav class="nav-buttons">
                <a href="{{ url('/dashboard') }}" class="btn btn-register">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-login">Log out</button>
                </form>
            </nav>
        @endauth
    </header>

    <!-- Hero Section -->
    <main class="hero">
        <div class="hero-content fade-in-up delay-1">
            <h1 class="hero-title">Welcome to MoodMix</h1>
            <p class="hero-subtitle">Your Mood, Your Music</p>
            <p class="hero-description">
                Discover the perfect playlist for every emotion. MoodMix creates personalized music experiences 
                based on how you feel, bringing you the right songs at the right time.
            </p>
            
            @if (Route::has('login'))
                <div class="hero-cta">
                    @auth
                        <a href="{{ route('recommendation.form') }}" class="btn btn-primary">Generate Playlist</a>
                        <a href="{{ route('playlist.index') }}" class="btn btn-secondary">My Library</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Sign In</a>
                    @endauth
                </div>
            @endif

            <!-- Features -->
            <div class="features fade-in-up delay-2">
                <div class="feature-card">
                    <!-- <div class="feature-icon">😊</div> -->
                    <h3 class="feature-title">Mood-Based</h3>
                    <p class="feature-description">Select your current mood and get instant playlist recommendations</p>
                </div>
                <div class="feature-card">
                    <!-- <div class="feature-icon">🎵</div> -->
                    <h3 class="feature-title">Smart Curation</h3>
                    <p class="feature-description">AI-powered music selection tailored to your preferences</p>
                </div>
                <div class="feature-card">
                    <!-- <div class="feature-icon">💾</div> -->
                    <h3 class="feature-title">Save & Share</h3>
                    <p class="feature-description">Create, save, and export your favorite playlists</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} MoodMix. All rights reserved. | Your mood, your soundtrack.</p>
    </footer>
</body>
</html>
