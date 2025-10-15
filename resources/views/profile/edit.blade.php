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
    align-items: center;
    justify-content: center;
    padding: 20px;
}

section {
    display: flex; 
    flex-direction: column; 
    width: 100%;
    max-width: 1200px;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border-radius: 50px;
}

header {
    padding: 20px 30px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 50px 50px 0 0;
    flex-shrink: 0;
}

main {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    min-height: 400px;
}

.header-title {
    font-size: 25px; 
    text-decoration: none; 
    font-weight:bolder; 
    color: #c4b537;
}

.profile-container {
    width: 100%;
    max-width: 700px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: stretch;
}

.profile-card {
    font-family: system-ui,'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgba(0, 0, 0, 0);
    border-radius: 15px;
    padding: 25px 30px;
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
    background: rgba(0, 0, 0, 0.3);
    padding: 12px 0;
    border-radius: 0 0 50px 50px;
    flex-shrink: 0;
}

.nav-list {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    gap: 60px;
    max-width: 600px;
    margin: 0 auto;
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
</style>
<title>Profile - MoodMix</title>
</head>
<body>
    <section class="fade-slide-in">
        <header style="display: flex">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo"/>
            <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
        </header>

        <main>
            <div class="profile-container">
                <div class="profile-card">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="profile-card">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </main>

        <div class="bottom-nav">
            <ul class="nav-list">
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('home-alt.png') }}" alt="home icon" style="width:24px; height:24px;">
                    <a href="{{ route('dashboard') }}">Home</a>
                </li>
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('user-circle.png') }}" alt="profile icon" style="width:24px; height:24px;">
                    <a href="{{ route('profile.edit') }}">Profile</a>
                </li>
                <li class="nav-item" style="display: flex">
                    <img src="{{ asset('list-music.png') }}" alt="playlist icon" style="width:24px; height:24px;">
                    <a href="{{ route('playlist.index') }}">Playlist</a>
                </li>
            </ul>
        </div>
    </section>
</body>
</html>