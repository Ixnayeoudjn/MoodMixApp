<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url('/main-bg.png');
    color: white;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

section {
    display: flex; 
    flex-direction: column; 
    justify-content: center; 
    flex: 1;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border-radius: 50px;
    margin: 40px;
}

header {
    padding: 20px 30px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 50px 50px 0 0;
}

main {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
}

.header-title {
    font-size: 25px; 
    text-decoration: none; 
    font-weight:bolder; 
    color: #c4b537;
}

.main-btn-container {
    font-family: system-ui,'Open Sans', 'Helvetica Neue', sans-serif;
    background: rgba(0, 0, 0, 0.4);
    border-radius: 50px;
    padding: 20px;
    transition: 0.3s ease;
}

.main-btn-container:hover {
    transform: translateY(-5px);
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transition: 0.3s ease;
}

.main-button {
    font-size: 25px;
    text-decoration: none;
    color: #c4b537;
    font-size: 1.5rem;
    font-weight: 300;
}

img {
    margin-right: 5px;
    width: 40px;
    height: 40px;
}

.welcome-title {
    font-size: 4rem;
    font-weight: 700;
    margin-bottom: 20px;
    background: linear-gradient(135deg, #c4b537 0%, #cdc045 100%); 
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.bottom-nav {
    background: rgba(0, 0, 0, 0.8);
    padding: 20px 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0 0 50px 50px;
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

.nav-icon {
    font-size: 1.5rem;
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
    .welcome-title {
        font-size: 2rem;
    }
    
    
    .mood-emoji {
        font-size: 3rem;
    }
    
    .nav-list {
        gap: 40px;
    }
}
</style>
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
            </ul>
        </div>
    </section>
</body>
</html>