<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MoodMix - Your Mood, Your Music</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('/main-bg.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* Header Navigation */
        .header {
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            width: 50px;
            height: 50px;
        }

        .logo-text {
            font-size: 28px;
            font-weight: bold;
            color: #c4b537;
            text-decoration: none;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-login {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #c4b537;
        }

        .btn-register {
            background: linear-gradient(135deg, #c4b537 0%, #f4e76e 100%);
            color: #1a1a1a;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(196, 181, 55, 0.4);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-content {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            padding: 80px 60px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .hero-title {
            font-size: 5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #c4b537 0%, #f4e76e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.8rem;
            color: #e0e0e0;
            margin-bottom: 20px;
            font-weight: 300;
        }

        .hero-description {
            font-size: 1.2rem;
            color: #b0b0b0;
            margin-bottom: 50px;
            max-width: 900px;
            line-height: 1.6;
            text-align: center;
        }

        .hero-cta {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #c4b537 0%, #f4e76e 100%);
            color: #1a1a1a;
            padding: 18px 45px;
            font-size: 1.2rem;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 18px 45px;
            font-size: 1.2rem;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #c4b537;
        }

        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 60px;
            max-width: 900px;
        }

        .feature-card {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #c4b537;
            box-shadow: 0 10px 30px rgba(196, 181, 55, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #c4b537;
        }

        .feature-description {
            font-size: 1rem;
            color: #b0b0b0;
            line-height: 1.5;
        }

        /* Footer */
        .footer {
            padding: 20px;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            color: #b0b0b0;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .delay-1 {
            animation-delay: 0.2s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        .delay-2 {
            animation-delay: 0.4s;
            opacity: 0;
            animation-fill-mode: forwards;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 20px;
            }

            .hero-content {
                padding: 40px 30p
            }

            .hero-title {
                font-size: 3rem;
            }

            .hero-subtitle {
                font-size: 1.3rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-cta {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header class="header fade-in-up">
        <div class="logo-section">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" class="logo-img">
            <a href="{{ url('/') }}" class="logo-text">MoodMix</a>
        </div>
        <!-- @if (Route::has('login'))
            <nav class="nav-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-register">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-register">Sign up</a>
                    @endif
                @endauth
            </nav>
        @endif -->
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
