<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Playlist Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            max-width: 80%;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 50px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .btn-back {
            margin-left: auto;
            background-color: transparent;
            color: #c4b537;
            font-weight: bold;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        #moodmixlogo {
            margin-right: 20px;
            width: 40px;
            height: 40px;
        }

        .header-title {
            font-size: 25px; 
            text-decoration: none; 
            font-weight: bolder; 
            color: #c4b537;
        }

        .main-title {
            color: #d4af37;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .section-header {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
        }

        .songs-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 350px; /* Limit height for scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .song-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #404040;
            transition: background-color 0.2s ease;
        }

        .album-cover {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            margin-right: 15px;
            object-fit: cover;
            background-color: #444444;
        }

        .song-info {
            flex: 1;
        }

        .song-title {
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .song-details {
            color: #b0b0b0;
            font-size: 14px;
        }

        .song-actions {
            margin-left: 15px;
            display: flex;
            gap: 10px;
        }

        .delete-button {
            background: none;
            border: none;
            color: #ff4444;
            font-size: 16px;
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .delete-button:hover {
            background-color: #ff4444;
            color: #ffffff;
        }

        .delete-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .export-btn {
            background: linear-gradient(135deg, #d4af37, #f4d03f);
            color: #1a1a1a;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 30px auto 0;
        }

        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }

        .song-count {
            color: #b0b0b0;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 16px;
        }

        .alert-success {
            background-color: #0606065e;
            color: #d4edda;
        }

        .alert-error {
            background-color: #721c24;
            color: #f8d7da;
        }

        .no-songs {
            text-align: center;
            color: #b0b0b0;
            padding: 40px;
            font-size: 16px;
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
    </style>
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
            <form method="POST" action="{{ route('spotify.export', $playlist->id) }}">
                @csrf
                <button type="submit" class="export-btn">Export to Spotify</button>
            </form>
        @else
            <a href="{{ route('spotify.auth') }}" class="export-btn" style="text-align: center; text-decoration: none;">Connect to Spotify</a>
        @endif
    </div>

    <script>
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
