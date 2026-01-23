<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Your Library</title>
    @vite(['resources/css/library-index.css'])
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