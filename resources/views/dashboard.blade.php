<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
@vite(['resources/css/dashboard.css'])
<title>Dashboard</title>
</head>
<body>
    <section class="fade-slide-in">
        <header style="display: flex">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo"/>
            <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
        </header>

        <main>
            <div class="welcome-title">Welcome to MoodMix</div>
            <div class="main-btn-container">
                <a href="{{ route('recommendation.form') }}" class="main-button">Generate Playlist</a>
            </div>
        </main>

        <div class="bottom-nav">
            <ul class="nav-list">
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('home-alt.png') }}" alt="home icon" style="width:24px; height:24px;">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('user-circle.png') }}" alt="profile icon" style="width:24px; height:24px;">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                </li>
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('list-music.png') }}" alt="playlist icon" style="width:24px; height:24px;">
                    <a href="{{ route('playlist.index') }}">Playlist</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <img src="{{ asset('logout-icon.png') }}" alt="logout icon" style="width:24px; height:24px;">
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </section>
</body>
</html>