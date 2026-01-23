<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
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
    background-repeat: no-repeat;
    color: white;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding: 0;
}

section {
    display: flex; 
    flex-direction: column; 
    width: 100%;
    background: transparent;
    backdrop-filter: none;
    border-radius: 0;
    flex: 1;
}

header {
    padding: 20px 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 0;
    flex-shrink: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 40px 20px;
    flex: 1;
}

.header-title {
    font-size: 25px; 
    text-decoration: none; 
    font-weight:bolder; 
    color: #c4b537;
    margin-right: auto;
}

.header-nav {
    display: flex;
    gap: 40px;
    align-items: center;
    list-style: none;
}

.header-nav a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-nav a:hover {
    color: #c4b537;
}

.profile-container {
    width: 95%;
    min-width: 900px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: stretch;
}

.profile-card {
    font-family: system-ui,'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 15px;
    padding: 30px;
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.profile-card h2 {
    font-size: 1.2rem;
    margin-bottom: 8px;
}

.profile-card p {
    font-size: 0.85rem;
    margin-bottom: 15px;
    opacity: 0.9;
}

.profile-card label {
    font-size: 0.9rem;
    margin-bottom: 5px;
    display: block;
}

.profile-card input,
.profile-card button {
    font-size: 0.9rem;
    padding: 10px 14px;
}

.profile-card > div {
    margin-bottom: 12px;
}

.profile-card form > div {
    margin-bottom: 12px;
}

img {
    margin-right: 5px;
    width: 40px;
    height: 40px;
}

.bottom-nav {
    background: transparent;
    padding: 20px 40px;
    border-radius: 0;
    flex-shrink: 0;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.nav-list {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    list-style: none;
    gap: 0;
    max-width: none;
    margin: 0;
}

.nav-item a {
    color: #e0e0e0;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-item a:hover {
    color: #c4b537;
}

@keyframes fade-slide-in {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-slide-in {
  animation: fade-slide-in 0.8s ease-out;
}

@media (max-width: 768px) {
    .nav-list {
        gap: 40px;
    }
    
    section {
        margin: 20px;
    }
}

/* Back Button */
.back-btn {
    background: linear-gradient(135deg, #c4b537 0%, #f4e76e 100%);
    color: #1a1a1a;
    border: none;
    padding: 10px 20px;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}

.back-btn:hover {
    transform: translateY(-2px);
}

.back-btn:active {
    transform: translateY(0);
}
</style>
<title>Profile - MoodMix</title>
</head>
<body>
    <section class="fade-slide-in">
        <header style="display: flex">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img src="{{ asset('logo.png') }}" alt="MoodMix Logo"/>
                <a href="{{ url('/') }}" class="header-title">MoodMix</a>
            </div>
            <ul class="header-nav">
                <li>
                    <img src="{{ asset('list-music.png') }}" alt="playlist icon" style="width:24px; height:24px;">
                    <a href="{{ route('playlist.index') }}">Playlist</a>
                </li>
                <li>
                    <img src="{{ asset('home-alt.png') }}" alt="home icon" style="width:24px; height:24px;">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li>
                    <img src="{{ asset('user-circle.png') }}" alt="profile icon" style="width:24px; height:24px;">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                </li>
            </ul>
        </header>
        <main>
            <div class="profile-container">
                <div class="profile-card">
                    @include('profile.partials.update-profile-information-form')

                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </main>
        <div class="bottom-nav">
            <a href="{{ route('recommendation.form') }}" class="back-btn">← Back to Create Playlist</a>
        </div>
    </section>
</body>
</html>