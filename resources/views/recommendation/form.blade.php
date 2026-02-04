<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>MoodMix - Create Playlist</title>
@vite(['resources/css/recommendation-form.css'])
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
            <div class="subtitle">How are you feeling today? Pick one:</div>
            
            <form class="recommendation-form" method="GET" action="{{ route('recommendation.results') }}" style="height: fit-content;">
                @csrf
                
                <!-- Mood Selection -->
                <div class="mood-section">
                    <div class="mood-grid">
                        <label class="mood-card" for="feeling-tired">
                            <div class="mood-emoji">😴</div>
                            <div class="mood-label" style="color: #ffffff;">Feeling tired?</div>
                            <input type="radio" name="feeling" value="tired" id="feeling-tired" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-lonely">
                            <div class="mood-emoji">🤍</div>
                            <div class="mood-label" style="color: #ffffff;">Feeling lonely?</div>
                            <input type="radio" name="feeling" value="lonely" id="feeling-lonely" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-stressed">
                            <div class="mood-emoji">😵‍💫</div>
                            <div class="mood-label" style="color: #ffffff;">Feeling stressed?</div>
                            <input type="radio" name="feeling" value="stressed" id="feeling-stressed" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-angry">
                            <div class="mood-emoji">😠</div>
                            <div class="mood-label" style="color: #ffffff">Feeling angry?</div>
                            <input type="radio" name="feeling" value="angry" id="feeling-angry" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-sad">
                            <div class="mood-emoji">😔</div>
                            <div class="mood-label" style="color: #ffffff">Feeling sad?</div>
                            <input type="radio" name="feeling" value="sad" id="feeling-sad" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-bored">
                            <div class="mood-emoji">🥱</div>
                            <div class="mood-label" style="color: #ffffff">Feeling bored?</div>
                            <input type="radio" name="feeling" value="bored" id="feeling-bored" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-happy">
                            <div class="mood-emoji">😊</div>
                            <div class="mood-label" style="color: #ffffff">Feeling happy?</div>
                            <input type="radio" name="feeling" value="happy" id="feeling-happy" class="mood-input" required>
                        </label>

                        <label class="mood-card" for="feeling-relaxed">
                            <div class="mood-emoji">😌</div>
                            <div class="mood-label" style="color: #ffffff">Feeling relaxed?</div>
                            <input type="radio" name="feeling" value="relaxed" id="feeling-relaxed" class="mood-input" required>
                        </label>
                    </div>
                </div>
                <div class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group genre-dropdown">
                            <label for="genre-input" class="filter-label">Genre</label>
                            <input type="text" id="genre-input" name="genre" class="filter-input" placeholder="Select genre (Optional)" autocomplete="off">
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
                            <label for="year_from" class="filter-label">Year Range</label>
                            <div class="year-input-group">
                                <div class="year-input-wrapper">
                                    <!-- <span class="year-label">From:</span> -->
                                    <input type="number" id="year_from" name="year_from" placeholder="1900" min="1900" max="2099" class="filter-input year-input">
                                </div>
                                <span class="year-separator">to</span>
                                <div class="year-input-wrapper">
                                    <!-- <span class="year-label">To:</span> -->
                                    <input type="number" id="year_to" name="year_to" placeholder="2099" min="1900" max="2099" class="filter-input year-input">
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <label for="song_count" class="filter-label">Number of Songs</label>
                            <input type="number" id="song_count" name="song_count" class="filter-input"
                                placeholder="20" min="1" max="100" value="20" required>
                            <!-- <div class="filter-helper">Choose how many song recommendations you'd like (1-100)</div> -->
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

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">Generating Your Playlist</div>
    <div class="loading-subtext">Finding the perfect songs for your mood...</div>
</div>

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
    const selectedFeeling = document.querySelector('input[name="feeling"]:checked');
    if (!selectedFeeling) {
        e.preventDefault();
        alert('Please select how you feel before getting recommendations.');
        return;
    }
    
    // Show loading overlay when form is submitted
    const loadingOverlay = document.getElementById('loadingOverlay');
    loadingOverlay.classList.add('active');
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