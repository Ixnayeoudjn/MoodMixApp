<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Playlist Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/library-show.css'])
</head>
<body>
    <div class="container fade-slide-in">
        <div class="header">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" id="moodmixlogo"/>
                <a href="{{ url('/') }}" class="header-title">MoodMix</a>
            </div>
            <a href="{{ route('playlist.index') }}" class="btn-back">Back to My Playlists</a>
        </div>

        <h1 class="main-title">{{ $playlist->name }}</h1>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="section-header">Playlist Info</div>
        <p><strong>Mood:</strong> {{ $playlist->mood_name }}</p>
        <p><strong>Year Range:</strong> {{ $playlist->year_from }} - {{ $playlist->year_to }}</p>

        <div class="section-header" style="margin-top: 30px;">
            Songs
            <div class="song-count">
                <span id="songCount">{{ $playlist->songs->count() }}</span> songs
            </div>
        </div>
        
        <ul class="songs-list" id="songsList">
            @forelse ($playlist->songs as $song)
                <li class="song-item" data-song-id="{{ $song->id }}">
                    @if (!empty($albumCovers[$song->id]))
                        <img src="{{ $albumCovers[$song->id] }}" alt="Cover" class="album-cover">
                    @else
                        <div class="album-cover"></div>
                    @endif
                    <div class="song-info">
                        <div class="song-title">{{ $song->title }}</div>
                        <div class="song-details">{{ $song->genre }} ({{ $song->year }})</div>
                    </div>
                    <div class="song-actions">
                        <button type="button" class="delete-button" onclick="removeSongFromPlaylist({{ $playlist->id }}, {{ $song->id }})">×</button>
                    </div>
                </li>
            @empty
                <li class="no-songs">No songs in this playlist.</li>
            @endforelse
        </ul>

        @if(session('spotify_access_token'))
            <form method="POST" action="{{ route('spotify.export', $playlist->id) }}" id="exportForm">
                @csrf
                <button type="submit" class="export-btn" id="exportBtn">Export to Spotify</button>
            </form>
        @else
            <a href="{{ route('spotify.auth') }}" class="export-btn" id="connectBtn" style="text-align: center; text-decoration: none;">Connect to Spotify</a>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text" id="loadingText">Processing</div>
        <div class="loading-subtext" id="loadingSubtext">Please wait...</div>
    </div>

    <script>
        // Show loading overlay when connecting to Spotify
        const connectBtn = document.getElementById('connectBtn');
        if (connectBtn) {
            connectBtn.addEventListener('click', function(e) {
                const loadingOverlay = document.getElementById('loadingOverlay');
                const loadingText = document.getElementById('loadingText');
                const loadingSubtext = document.getElementById('loadingSubtext');
                
                loadingText.textContent = 'Connecting to Spotify';
                loadingSubtext.textContent = 'Redirecting to Spotify...';
                loadingOverlay.classList.add('active');
            });
        }

        // Show loading overlay when exporting to Spotify
        const exportForm = document.getElementById('exportForm');
        if (exportForm) {
            exportForm.addEventListener('submit', function(e) {
                const loadingOverlay = document.getElementById('loadingOverlay');
                const loadingText = document.getElementById('loadingText');
                const loadingSubtext = document.getElementById('loadingSubtext');
                
                loadingText.textContent = 'Exporting to Spotify';
                loadingSubtext.textContent = 'Creating your playlist...';
                loadingOverlay.classList.add('active');
            });
        }
        function removeSongFromPlaylist(playlistId, songId) {
            if (!confirm('Are you sure you want to remove this song from the playlist?')) {
                return;
            }

            const button = document.querySelector(`[data-song-id="${songId}"] .delete-button`);
            button.disabled = true;
            button.textContent = '...';

            fetch(`/playlist/${playlistId}/remove-song`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    song_id: songId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the song item from the DOM
                    const songItem = document.querySelector(`[data-song-id="${songId}"]`);
                    if (songItem) {
                        songItem.remove();
                        updateSongCount();
                        
                        // Check if no songs remain
                        const songsList = document.getElementById('songsList');
                        if (songsList.children.length === 0) {
                            songsList.innerHTML = '<li class="no-songs">No songs in this playlist.</li>';
                        }
                    }
                    
                    // Show success message
                    showAlert('Song removed successfully!', 'success');
                } else {
                    showAlert(data.message || 'Error removing song', 'error');
                    button.disabled = false;
                    button.textContent = '×';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error removing song', 'error');
                button.disabled = false;
                button.textContent = '×';
            });
        }

        function updateSongCount() {
            const songCount = document.querySelectorAll('.song-item[data-song-id]').length;
            document.getElementById('songCount').textContent = songCount;
        }

        function showAlert(message, type) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;

            // Insert after the main title
            const mainTitle = document.querySelector('.main-title');
            mainTitle.parentNode.insertBefore(alert, mainTitle.nextSibling);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }
    </script>
</body>
</html>
