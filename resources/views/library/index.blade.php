<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Your Library</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-image: url('/main-bg.png');
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            min-height: calc(100vh - 40px);
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        #moodmixlogo {
            margin-right: 20px;
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
            color: #d4af37;
            font-size: 24px;
            font-weight: bold;
            margin-right: 10px;
        }

        .app-name {
            color: #d4af37;
            font-size: 24px;
            font-weight: bold;
        }

        .main-title {
            color: #d4af37;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            color: #ffffff;
            font-size: 20px;
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            background: rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            color: #ffffff;
            font-size: 14px;
            width: 180px;
            transition: background-color 0.2s ease;
        }

        .search-box:focus {
            outline: none;
            background: rgba(54, 54, 54, 0.3);
        }

        .search-box::placeholder {
            color: #b0b0b0;
        }

        .filter-box {
            background: rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            color: #ffffff;
            font-size: 14px;
            width: 180px;
            transition: background-color 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .filter-box:focus {
            outline: none;
            background: rgba(54, 54, 54, 0.3);
        }

        .filter-box option {
            color: #000; /* ensure readability in native menu */
        }

        .create-btn {
            background: rgba(0, 0, 0, 0.3);
            border: none;
            border-radius: 20px;
            padding: 8px 15px;
            color: #ffffff;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s ease;
        }

        .create-btn:hover {
            background: rgba(54, 54, 54, 0.3);
        }

        .playlists-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
            min-height: 500px;
        }

        .playlist-card {
            height: fit-content;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            padding: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .playlist-card:hover {
            background-color: #404040;
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .playlist-cover {
            width: 100%;
            height: 180px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 2px;
            background-color: #4a4a4a;
            overflow: hidden;
        }

        .playlist-cover.single-cover {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cover-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background-color: #555555;
        }

        .liked-songs-cover {
            background: linear-gradient(135deg, #8b5cf6, #a855f7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #ffffff;
        }

        .default-cover {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #ffffff;
        }

        .playlist-info {
            text-align: left;
        }

        .playlist-name {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .playlist-count {
            color: #b0b0b0;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            color: #b0b0b0;
            padding: 60px 20px;
            font-size: 18px;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
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

        .playlists-grid {
            margin-bottom: 30px;
            max-height: 480px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .delete-btn {
            background: transparent;
            border: none;
            color: #e74c3c;
            font-size: 20px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            transition: color 0.2s;
        }
        .delete-btn:hover {
            color: #c0392b;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-slide-in {
        animation: fadeSlideIn 0.8s ease-out;
        }

        @media (max-width: 768px) {
            .playlists-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .playlist-cover {
                height: 150px;
            }
            
            .header-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .search-box {
                width: 140px;
            }
        }
    .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success {
            background: rgba(40, 167, 69, 0.15);
            border: 1px solid rgba(40, 167, 69, 0.4);
            color: #a1f0b6;
        }

        /* Loading Animation */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(244, 208, 63, 0.2);
            border-top: 6px solid #f4d03f;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            color: #f4d03f;
            font-size: 1.3rem;
            font-weight: 600;
            text-align: center;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
        }

        .loading-subtext {
            color: #e0e0e0;
            font-size: 0.95rem;
            margin-top: 10px;
            animation: pulse 1.5s ease-in-out infinite 0.3s;
        }
    </style>
</head>
<body>
    <div class="container fade-slide-in">
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" id="moodmixlogo"/>
            <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
        </div>

        <h1 class="main-title">Your Library</h1>

        @if (session('success'))
            <div class="alert alert-success">{!! session('success') !!}</div>
        @endif

        <div class="section-header">
            <h2 class="section-title">Playlists</h2>
            <div class="header-actions">
                <form action="{{ route('playlist.index') }}" method="GET" id="searchForm" style="display: inline;">
                    <input type="text" class="search-box" name="search" placeholder="Search in Playlists" value="{{ request('search') }}" id="searchInput">
                </form>
                {{-- <select id="moodFilter" class="filter-box" aria-label="Filter by mood">
                    <option value="all" {{ request('mood') === null || request('mood') === 'all' ? 'selected' : '' }}>All moods</option>
                    <option value="Q1" {{ request('mood') === 'Q1' ? 'selected' : '' }}>Happy (Q1)</option>
                    <option value="Q2" {{ request('mood') === 'Q2' ? 'selected' : '' }}>Angry (Q2)</option>
                    <option value="Q3" {{ request('mood') === 'Q3' ? 'selected' : '' }}>Sad (Q3)</option>
                    <option value="Q4" {{ request('mood') === 'Q4' ? 'selected' : '' }}>Relaxed (Q4)</option>
                </select> --}}
                <form action="{{ route('recommendation.form') }}" method="GET">
                    <button type="submit" class="create-btn">
                        <span>+ Create</span>
                    </button>
                </form>
            </div>
        </div>

<div class="playlists-grid">
    @forelse($playlists as $playlist)
        <div class="playlist-card" data-mood="{{ $playlist->mood }}">
            <!-- Delete form/button -->
            <form action="{{ route('playlist.destroy', $playlist->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" title="Delete Playlist">&times;</button>
            </form>

            <!-- Link to show view -->
            <a href="{{ route('playlist.show', $playlist->id) }}" style="text-decoration: none">
                <div class="playlist-cover {{ $playlist->name === 'Liked Songs' ? 'single-cover' : '' }}">
                    @if($playlist->name === 'Liked Songs')
                        <div class="liked-songs-cover">❤️</div>
                    @elseif(!empty($playlist->album_covers) && count($playlist->album_covers) > 0)
                        @foreach(array_slice($playlist->album_covers, 0, 4) as $cover)
                            <img src="{{ $cover }}" alt="Album cover" class="cover-image">
                        @endforeach
                        @for($i = count($playlist->album_covers); $i < 4; $i++)
                            <div class="cover-image default-cover">🎵</div>
                        @endfor
                    @else
                        <div class="default-cover">🎵</div>
                    @endif
                </div>

                <div class="playlist-info">
                    <div class="playlist-name">{{ $playlist->name }}</div>
                    <div class="playlist-count">{{ $playlist->songs_count }} Songs</div>
                </div>
            </a>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-state-icon">🎵</div>
            <div>You haven't saved any playlists yet.</div>
        </div>
    @endforelse
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
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Loading Playlist</div>
        <div class="loading-subtext">Fetching your songs...</div>
    </div>

    <script>
        // Show loading overlay when clicking on a playlist
        document.querySelectorAll('.playlist-card a').forEach(link => {
            link.addEventListener('click', function(e) {
                const loadingOverlay = document.getElementById('loadingOverlay');
                loadingOverlay.classList.add('active');
            });
        });

        // Search functionality - submit form on input
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                searchForm.submit();
            }, 500); // Wait 500ms after user stops typing
        });

        // Also submit on Enter key
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                searchForm.submit();
            }
        });

        // Mood filter functionality - client-side filtering by quadrant
        const moodFilter = document.getElementById('moodFilter');
        const playlistCards = document.querySelectorAll('.playlist-card');

        function applyMoodFilter() {
            const selected = moodFilter ? moodFilter.value : 'all';
            playlistCards.forEach(card => {
                const mood = card.dataset.mood || '';
                const visible = selected === 'all' || mood === selected;
                card.style.display = visible ? '' : 'none';
            });
        }

        if (moodFilter) {
            moodFilter.addEventListener('change', applyMoodFilter);
            // Apply on load in case a value is preselected
            applyMoodFilter();
        }
    </script>
</body>
</html>