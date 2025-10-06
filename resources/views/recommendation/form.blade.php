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
    background: #c4b537;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;        /* Larger emoji font */
    margin: 0 auto 18px;    /* Increased margin-bottom */
    color: #1a1a1a;
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
            <div class="nav-container">
                <ul class="nav-list">
                    <li class="nav-item">
                        <img src="{{ asset('home-alt.png') }}" alt="home icon" style="width:24px; height:24px;">
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <img src="{{ asset('user-circle.png') }}" alt="profile icon" style="width:24px; height:24px;">
                        <a href="{{ route('profile.edit') }}">Profile</a>
                    </li>
                    <li class="nav-item">
                        <img src="{{ asset('list-music.png') }}" alt="playlist icon" style="width:24px; height:24px;">
                        <a href="{{ route('playlist.index') }}">Playlist</a>
                    </li>
                </ul>
            </div>
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
                            <div class="mood-emoji"><img src="/1.png" alt="happy-emoji" style="width: 125px; height: 130px;"></div>
                            <div class="mood-label" style="color: #f5dc00">Happy</div>
                            <input type="radio" name="mood" value="Q1" id="mood-happy" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-sad">
                            <div class="mood-emoji"><img src="/2.png" alt="happy-emoji" style="width: 125px; height: 130px;"></div>
                            <div class="mood-label" style="color: #4768c2">Sad</div>
                            <input type="radio" name="mood" value="Q3" id="mood-sad" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-angry">
                            <div class="mood-emoji"><img src="/3.png" alt="happy-emoji" style="width: 125px; height: 130px;"></div>
                            <div class="mood-label" style="color: #e24646">Angry</div>
                            <input type="radio" name="mood" value="Q2" id="mood-angry" class="mood-input" required>
                        </label>
                        
                        <label class="mood-card" for="mood-relaxed">
                            <div class="mood-emoji"><img src="/4.png" alt="happy-emoji" style="width: 125px; height: 130px;"></div>
                            <div class="mood-label" style="color: #69cc79">Relaxed</div>
                            <input type="radio" name="mood" value="Q4" id="mood-relaxed" class="mood-input" required>
                        </label>
                    </div>
                </div>
                <div class="filters-section">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <input type="text" name="genre" class="filter-input" placeholder="Genre (Optional)">
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
</script>
</body>
</html>