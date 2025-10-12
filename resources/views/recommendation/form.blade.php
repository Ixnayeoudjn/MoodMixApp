<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>MoodMix - Create Playlist</title>
<style>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>MoodMix - Create Playlist</title>
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
    overflow-y: hidden
}

section {
    margin: 40px;
    border-radius: 50px;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
}

/* Header */
.header {
    padding: 20px 30px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 50px 50px 0 0;
    backdrop-filter: blur(10px);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

img {
    margin-right: 5px;
    width: 40px;
    height: 40px;
}

.header-title {
    font-size: 25px; 
    text-decoration: none; 
    font-weight:bolder; 
    color: #c4b537;
}

.logo {
    color: #c4b537;
    font-size: 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.logo::before {
    font-size: 1.2em;
}

.nav-container {
    display: flex;
    align-items: center;
}

.nav-list {
    display: flex;
    list-style: none;
    gap: 30px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-item a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-item a:hover {
    color: #c4b537;
}

/* Main Content */
.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
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

.subtitle {
    font-size: 1.5rem;
    color: #e0e0e0;
    margin-bottom: 50px;
    font-weight: 300;
}

/* Form */
.recommendation-form {
    max-width: 800px;
    width: 100%;
}

/* Mood Selection */
.mood-section {
    margin-bottom: 60px;
}

.mood-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
}

.mood-card {
    background: rgba(0, 0, 0, 0.4);
    border-radius: 24px;
    padding: 40px 26px;  /* Increased padding */
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
    backdrop-filter: blur(5px);
    position: relative;
    font-size: 1.18rem;     /* Slightly larger text inside card */
}

.mood-emoji {
    width: 105px;           /* Increased width */
    height: 105px;          /* Increased height */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;        /* Larger emoji font */
    margin: 0 auto 18px;    /* Increased margin-bottom */
    filter: grayscale(0);
}

.mood-card:hover {
    transform: translateY(-5px);
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transition: 0.3s ease;
}

.mood-card.selected {
    border-color: #c4b537;
    background: rgba(196, 181, 55, 0.2);
}

.mood-label {
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
}

.mood-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

/* Filters Section */
.filters-section {
    margin-bottom: 40px;
}

.filters-grid {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-select {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    color: white;
    font-size: 1rem;
    padding: 12px 7px;
    min-width: 100px;
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #a4a4a4;
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transition: 0.3s ease;
}

.filter-select option {
    background: #1a1a1a;
    color: white;
}

.filter-input {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 12px 16px;
    color: white;
    font-size: 1rem;
    min-width: 100px;
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}

.filter-input:focus {
    outline: none;
    border-color: #a4a4a4;
    background-color: rgba(255, 255, 255, 0.1);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    transition: 0.3s ease;
}

.filter-input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.year-separator {
    color: #e0e0e0;
    font-weight: 500;
}

/* Submit Button */
.submit-btn {
    background: linear-gradient(135deg, #c4b537 0%, #f4e76e 100%);
    color: #1a1a1a;
    border: none;
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 20px;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(196, 181, 55, 0.4);
}

.submit-btn:active {
    transform: translateY(0);
}

@keyframes fadeSlideIn {
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
  animation: fadeSlideIn 0.8s ease-out;
}


/* Genre dropdown */
.genre-dropdown {
    position: relative;
}
.dropdown-trigger {
    background: rgba(0, 0, 0, 0.4);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 12px 16px;
    color: white;
    font-size: 1rem;
    min-width: 260px;
    text-align: left;
    cursor: pointer;
}
.dropdown-trigger:focus {
    outline: none;
    border-color: #a4a4a4;
    background-color: rgba(255, 255, 255, 0.1);
}
.dropdown-panel {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    z-index: 50;
    min-width: 320px;
    background: rgba(0, 0, 0, 0.85);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 10px;
    backdrop-filter: blur(8px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}
.genre-dropdown:hover .dropdown-panel,
.genre-dropdown:focus-within .dropdown-panel {
    display: block;
}
.genre-list {
    max-height: 220px;
    overflow-y: auto;
    padding: 6px 2px;
}
.genre-item {
    display: block;
    padding: 6px 8px;
    border-radius: 6px;
    transition: background-color 0.2s ease;
    white-space: nowrap;
}
.genre-item:hover {
    background-color: rgba(255,255,255,0.08);
}
.genre-item input {
    margin-right: 10px;
}
.bottom-nav {
    background: rgba(0, 0, 0, 0.3);
    padding: 12px 0;
    border-radius: 0 0 50px 50px;
}
.bottom-nav .nav-list {
    display: flex;
    justify-content: center;
    align-items: center;
    list-style: none;
    gap: 60px;
    max-width: 600px;
    margin: 0 auto;
}
.bottom-nav .nav-item {
    display: flex;
    align-items: center;
    gap: 8px;
}
.bottom-nav .nav-item a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 500;
}
.bottom-nav .nav-item a:hover {
    color: #c4b537;
}
.bottom-nav .nav-item img {
    width: 24px;
    height: 24px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }
    
    .nav-list {
        gap: 20px;
    }
    
    .welcome-title {
        font-size: 2rem;
    }
    
    .subtitle {
        font-size: 1.2rem;
    }
    
    .mood-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    
    .mood-card {
        padding: 20px 15px;
    }
    
    .mood-emoji {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
    
    .filters-grid {
        flex-direction: column;
        gap: 15px;
    }
    
    .filter-group {
        flex-direction: column;
        gap: 5px;
    }
}
</style>
</head>
<body>
    <section class="fade-slide-in">
        <div class="header">
            <header style="display: flex">
                <img src="{{ asset('logo.png') }}" alt="MoodMix Logo"/>
                <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
            </header>
                    </div>

        <div class="main-content">
            <div class="welcome-title">MoodMix</div>
            <div class="subtitle">Select your preferred playlist mood:</div>
            
            <form class="recommendation-form" method="GET" action="{{ route('recommendation.results') }}">
                @csrf
                
                <!-- Mood Selection -->
                <div class="mood-section">
                    <div class="mood-grid">
                        <label class="mood-card" for="mood-happy">
                            <div class="mood-emoji">😊</div>
                            <div class="mood-label" style="color: #f5dc00">Happy</div>
                            <input type="radio" name="mood" value="Q1" id="mood-happy" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-sad">
                            <div class="mood-emoji">😔</div>
                            <div class="mood-label" style="color: #4768c2">Sad</div>
                            <input type="radio" name="mood" value="Q3" id="mood-sad" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-angry">
                            <div class="mood-emoji">😠</div>
                            <div class="mood-label" style="color: #e24646">Angry</div>
                            <input type="radio" name="mood" value="Q2" id="mood-angry" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-relaxed">
                            <div class="mood-emoji">😌</div>
                            <div class="mood-label" style="color: #69cc79">Relaxed</div>
                            <input type="radio" name="mood" value="Q4" id="mood-relaxed" class="mood-input" required>
                        </label>
                    </div>
                </div>
                <div class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group genre-dropdown">
                            <input type="text" id="genre-input" name="genre" class="filter-input" placeholder="Select genres (Optional)" autocomplete="off">
                            <div class="dropdown-panel">
                                <div class="genre-list">
                                    <div class="genre-item" data-genre="adult alternative">adult alternative</div>
                                    <div class="genre-item" data-genre="adult alternative pop/rock">adult alternative pop/rock</div>
                                    <div class="genre-item" data-genre="adult contemporary">adult contemporary</div>
                                    <div class="genre-item" data-genre="album rock">album rock</div>
                                    <div class="genre-item" data-genre="alternative dance">alternative dance</div>
                                    <div class="genre-item" data-genre="alternative metal">alternative metal</div>
                                    <div class="genre-item" data-genre="alternative pop/rock">alternative pop/rock</div>
                                    <div class="genre-item" data-genre="alternative rap">alternative rap</div>
                                    <div class="genre-item" data-genre="alternative/indie rock">alternative/indie rock</div>
                                    <div class="genre-item" data-genre="am pop">am pop</div>
                                    <div class="genre-item" data-genre="americana">americana</div>
                                    <div class="genre-item" data-genre="art rock">art rock</div>
                                    <div class="genre-item" data-genre="avant-garde">avant-garde</div>
                                    <div class="genre-item" data-genre="baroque pop">baroque pop</div>
                                    <div class="genre-item" data-genre="black gospel">black gospel</div>
                                    <div class="genre-item" data-genre="blue-eyed soul">blue-eyed soul</div>
                                    <div class="genre-item" data-genre="blues">blues</div>
                                    <div class="genre-item" data-genre="brill building pop">brill building pop</div>
                                    <div class="genre-item" data-genre="british invasion">british invasion</div>
                                    <div class="genre-item" data-genre="british metal">british metal</div>
                                    <div class="genre-item" data-genre="british psychedelia">british psychedelia</div>
                                    <div class="genre-item" data-genre="british punk">british punk</div>
                                    <div class="genre-item" data-genre="britpop">britpop</div>
                                    <div class="genre-item" data-genre="cast recordings">cast recordings</div>
                                    <div class="genre-item" data-genre="celtic">celtic</div>
                                    <div class="genre-item" data-genre="celtic new age">celtic new age</div>
                                    <div class="genre-item" data-genre="celtic rock">celtic rock</div>
                                    <div class="genre-item" data-genre="children's">children's</div>
                                    <div class="genre-item" data-genre="christmas">christmas</div>
                                    <div class="genre-item" data-genre="classical">classical</div>
                                    <div class="genre-item" data-genre="club/dance">club/dance</div>
                                    <div class="genre-item" data-genre="college rock">college rock</div>
                                    <div class="genre-item" data-genre="comedy/spoken">comedy/spoken</div>
                                    <div class="genre-item" data-genre="contemporary celtic">contemporary celtic</div>
                                    <div class="genre-item" data-genre="contemporary country">contemporary country</div>
                                    <div class="genre-item" data-genre="contemporary jazz">contemporary jazz</div>
                                    <div class="genre-item" data-genre="contemporary pop/rock">contemporary pop/rock</div>
                                    <div class="genre-item" data-genre="contemporary r&b">contemporary r&b</div>
                                    <div class="genre-item" data-genre="contemporary singer/songwriter">contemporary singer/songwriter</div>
                                    <div class="genre-item" data-genre="country">country</div>
                                    <div class="genre-item" data-genre="country-pop">country-pop</div>
                                    <div class="genre-item" data-genre="country-rock">country-rock</div>
                                    <div class="genre-item" data-genre="dance-pop">dance-pop</div>
                                    <div class="genre-item" data-genre="dance-rock">dance-rock</div>
                                    <div class="genre-item" data-genre="deep soul">deep soul</div>
                                    <div class="genre-item" data-genre="disco">disco</div>
                                    <div class="genre-item" data-genre="doom metal">doom metal</div>
                                    <div class="genre-item" data-genre="dream pop">dream pop</div>
                                    <div class="genre-item" data-genre="early pop/rock">early pop/rock</div>
                                    <div class="genre-item" data-genre="east coast rap">east coast rap</div>
                                    <div class="genre-item" data-genre="electronic">electronic</div>
                                    <div class="genre-item" data-genre="ethnic fusion">ethnic fusion</div>
                                    <div class="genre-item" data-genre="euro-pop">euro-pop</div>
                                    <div class="genre-item" data-genre="folk">folk</div>
                                    <div class="genre-item" data-genre="folk-rock">folk-rock</div>
                                    <div class="genre-item" data-genre="funk">funk</div>
                                    <div class="genre-item" data-genre="garage rock">garage rock</div>
                                    <div class="genre-item" data-genre="gospel">gospel</div>
                                    <div class="genre-item" data-genre="goth metal">goth metal</div>
                                    <div class="genre-item" data-genre="grunge">grunge</div>
                                    <div class="genre-item" data-genre="hard rock">hard rock</div>
                                    <div class="genre-item" data-genre="hardcore rap">hardcore rap</div>
                                    <div class="genre-item" data-genre="heartland rock">heartland rock</div>
                                    <div class="genre-item" data-genre="heavy metal">heavy metal</div>
                                    <div class="genre-item" data-genre="hip-hop">hip-hop</div>
                                    <div class="genre-item" data-genre="holidays">holidays</div>
                                    <div class="genre-item" data-genre="holiday">holiday</div>
                                    <div class="genre-item" data-genre="house">house</div>
                                    <div class="genre-item" data-genre="industrial">industrial</div>
                                    <div class="genre-item" data-genre="industrial dance">industrial dance</div>
                                    <div class="genre-item" data-genre="instrumental pop">instrumental pop</div>
                                    <div class="genre-item" data-genre="instrumental rock">instrumental rock</div>
                                    <div class="genre-item" data-genre="international">international</div>
                                    <div class="genre-item" data-genre="jazz">jazz</div>
                                    <div class="genre-item" data-genre="latin pop">latin pop</div>
                                    <div class="genre-item" data-genre="lounge">lounge</div>
                                    <div class="genre-item" data-genre="mainstream rock">mainstream rock</div>
                                    <div class="genre-item" data-genre="merseybeat">merseybeat</div>
                                    <div class="genre-item" data-genre="metal">metal</div>
                                    <div class="genre-item" data-genre="midwest rap">midwest rap</div>
                                    <div class="genre-item" data-genre="modern blues">modern blues</div>
                                    <div class="genre-item" data-genre="modern country">modern country</div>
                                    <div class="genre-item" data-genre="modern electric blues">modern electric blues</div>
                                    <div class="genre-item" data-genre="modern rock">modern rock</div>
                                    <div class="genre-item" data-genre="motown">motown</div>
                                    <div class="genre-item" data-genre="neo-prog">neo-prog</div>
                                    <div class="genre-item" data-genre="new age">new age</div>
                                    <div class="genre-item" data-genre="new romantic">new romantic</div>
                                    <div class="genre-item" data-genre="new wave">new wave</div>
                                    <div class="genre-item" data-genre="northern soul">northern soul</div>
                                    <div class="genre-item" data-genre="oldies">oldies</div>
                                    <div class="genre-item" data-genre="orchestral pop">orchestral pop</div>
                                    <div class="genre-item" data-genre="outlaw country">outlaw country</div>
                                    <div class="genre-item" data-genre="pop">pop</div>
                                    <div class="genre-item" data-genre="pop/rock">pop/rock</div>
                                    <div class="genre-item" data-genre="pop-soul">pop-soul</div>
                                    <div class="genre-item" data-genre="post-grunge">post-grunge</div>
                                    <div class="genre-item" data-genre="post-punk">post-punk</div>
                                    <div class="genre-item" data-genre="prog-rock">prog-rock</div>
                                    <div class="genre-item" data-genre="progressive metal">progressive metal</div>
                                    <div class="genre-item" data-genre="progressive rock">progressive rock</div>
                                    <div class="genre-item" data-genre="psychedelic">psychedelic</div>
                                    <div class="genre-item" data-genre="psychedelic pop">psychedelic pop</div>
                                    <div class="genre-item" data-genre="punk">punk</div>
                                    <div class="genre-item" data-genre="punk/new wave">punk/new wave</div>
                                    <div class="genre-item" data-genre="r&b">r&b</div>
                                    <div class="genre-item" data-genre="rap">rap</div>
                                    <div class="genre-item" data-genre="reggae">reggae</div>
                                    <div class="genre-item" data-genre="rock & roll">rock & roll</div>
                                    <div class="genre-item" data-genre="roots rock">roots rock</div>
                                    <div class="genre-item" data-genre="singer/songwriter">singer/songwriter</div>
                                    <div class="genre-item" data-genre="ska">ska</div>
                                    <div class="genre-item" data-genre="smooth soul">smooth soul</div>
                                    <div class="genre-item" data-genre="soft rock">soft rock</div>
                                    <div class="genre-item" data-genre="soul">soul</div>
                                    <div class="genre-item" data-genre="southern rock">southern rock</div>
                                    <div class="genre-item" data-genre="speed/thrash metal">speed/thrash metal</div>
                                    <div class="genre-item" data-genre="standards">standards</div>
                                    <div class="genre-item" data-genre="sunshine pop">sunshine pop</div>
                                    <div class="genre-item" data-genre="swedish pop/rock">swedish pop/rock</div>
                                    <div class="genre-item" data-genre="symphonic rock">symphonic rock</div>
                                    <div class="genre-item" data-genre="synth pop">synth pop</div>
                                    <div class="genre-item" data-genre="teen idols">teen idols</div>
                                    <div class="genre-item" data-genre="traditional country">traditional country</div>
                                    <div class="genre-item" data-genre="traditional pop">traditional pop</div>
                                    <div class="genre-item" data-genre="urban">urban</div>
                                    <div class="genre-item" data-genre="vocal">vocal</div>
                                    <div class="genre-item" data-genre="vocal jazz">vocal jazz</div>
                                    <div class="genre-item" data-genre="vocal pop">vocal pop</div>
                                    <div class="genre-item" data-genre="world">world</div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <input type="number" name="year_from" placeholder="Year" min="1900" max="2099" class="filter-input">
                            <span class="year-separator">to</span>
                            <input type="number" name="year_to" placeholder="Year" min="1900" max="2099" class="filter-input">
                        </div>
                        <div class="filter-group">
                            <input type="number" name="song_count" class="filter-input"
                                placeholder="Number of songs (1-100)" min="1" max="100" value="20" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit-btn">Get Recommendations</button>
            </form>
        </div>
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

<script>
// Handle mood selection visual feedback
document.querySelectorAll('.mood-input').forEach(input => {
    input.addEventListener('change', function() {
        // Remove selected class from all cards
        document.querySelectorAll('.mood-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to the current card
        this.closest('.mood-card').classList.add('selected');
    });
});

// Handle form submission
document.querySelector('.recommendation-form').addEventListener('submit', function(e) {
    const selectedMood = document.querySelector('input[name="mood"]:checked');
    if (!selectedMood) {
        e.preventDefault();
        alert('Please select a mood before getting recommendations.');
        return;
    }
});
// Genre dropdown with text input and clickable items
(function() {
    const genreInput = document.getElementById('genre-input');
    const genreItems = document.querySelectorAll('.genre-item');
    const dropdown = document.querySelector('.genre-dropdown');
    
    if (!genreInput || !genreItems.length) return;

    // Filter genres as user types
    genreInput.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase();
        genreItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? '' : 'none';
        });
    });

    // When a genre is clicked, populate the input and close dropdown
    genreItems.forEach(item => {
        item.addEventListener('click', function() {
            const genre = this.getAttribute('data-genre');
            genreInput.value = genre;
            dropdown.blur(); // Close dropdown by removing focus
        });
    });

    // Show dropdown when input is focused
    genreInput.addEventListener('focus', function() {
        dropdown.classList.add('active');
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
})();
</script>
</body>
</html>