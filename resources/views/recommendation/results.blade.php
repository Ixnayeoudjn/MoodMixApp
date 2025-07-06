<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Recommended Songs</title>
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

        .recommendations-section {
            margin-bottom: 30px;
            max-height: 340px;
            overflow-y: auto;
            padding-right: 10px;
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
            text-align: center;
            margin-bottom: 30px;
        }

        .playlist-form {
            margin-bottom: 30px;
        }

        .form-section {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .form-section label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
            font-weight: 500;
        }

        .form-section input[type="text"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: #ffffff;
            font-size: 16px;
        }

        .form-section input[type="text"]:focus {
            outline: none;
            background-color: #555555;
        }

        .recommendations-section {
            margin-bottom: 30px;
        }

        .section-header {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #444444;
        }

        .songs-list {
            list-style: none;
        }

        .song-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #404040;
            transition: background-color 0.2s ease;
        }

        .song-item:hover {
            border-radius: 8px;
            margin: 0 -10px;
            padding: 15px 10px;
        }

        .song-item:last-child {
            border-bottom: none;
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

        .more-options {
            background: none;
            border: none;
            color: #b0b0b0;
            font-size: 18px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.2s ease;
        }

        .more-options:hover {
            background-color: #444444;
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

        .save-button {
            background: linear-gradient(135deg, #d4af37, #f4d03f);
            color: #1a1a1a;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            margin: 20px auto 0;
        }

        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }

        .no-songs {
            text-align: center;
            color: #b0b0b0;
            padding: 40px;
            font-size: 16px;
        }

        .bottom-nav {
            padding: 20px 0;
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
            margin-left: 5px;
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

        .song-count {
            color: #b0b0b0;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
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
        <div class="header" style="display: flex">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" id="moodmixlogo"/>
            <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
        </div>

        <h1 class="main-title">Recommended Songs</h1>

        <form method="POST" action="{{ route('playlist.save') }}" class="playlist-form">
            @csrf
            <input type="hidden" name="mood" value="{{ $filters['mood'] }}">
            <input type="hidden" name="year_from" value="{{ $filters['year_from'] ?? '' }}">
            <input type="hidden" name="year_to" value="{{ $filters['year_to'] ?? '' }}">
            @foreach ($filters['genres'] ?? [] as $genre)
            <input type="hidden" name="genres[]" value="{{ $genre }}">
            @endforeach

            <div class="form-section">
                <label for="name">Playlist Name:</label>
                <input type="text" name="name" id="name" required placeholder="Enter playlist name...">
            </div>

            <div class="recommendations-section" style="overflow: auto">
                <div class="section-header">
                    Recommendations
                    <div class="song-count">
                        <span id="songCount">{{ count($songs) }}</span> songs
                    </div>
                </div>
                <ul class="songs-list" id="songsList">
                    @forelse ($songs as $song)
                    <li class="song-item" data-song-id="{{ $song->id }}">
                        <input type="hidden" name="song_ids[]" value="{{ $song->id }}">
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
                            <button type="button" class="delete-button" onclick="removeSong({{ $song->id }})">×</button>
                        </div>
                    </li>
                    @empty
                    <li class="no-songs">No songs found for the selected filters.</li>
                    @endforelse
                </ul>
            </div>

            <button type="submit" class="save-button">Save Playlist</button>
        </form>

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
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-error">{{ session('error') }}</div>
@endif
<script>
    function removeSong(songId) {
        if (!confirm('Are you sure you want to remove this song from the recommendations?')) {
            return;
        }

        const songItem = document.querySelector(`[data-song-id="${songId}"]`);
        const deleteButton = songItem.querySelector('.delete-button');
        deleteButton.disabled = true;
        deleteButton.textContent = '...';

        // Optional: Send AJAX to server (not necessary unless session data is stored)
        fetch('/recommend/remove-song', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({ song_id: songId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                songItem.remove();
                updateSongCount();

                const songsList = document.getElementById('songsList');
                if (songsList.querySelectorAll('.song-item').length === 0) {
                    songsList.innerHTML = '<li class="no-songs">No songs remaining in playlist.</li>';
                }

                showAlert('Song removed from recommendations.', 'success');
            } else {
                deleteButton.disabled = false;
                deleteButton.textContent = '×';
                showAlert(data.message || 'Failed to remove song.', 'error');
            }
        })
        .catch(err => {
            deleteButton.disabled = false;
            deleteButton.textContent = '×';
            showAlert('Failed to remove song.', 'error');
            console.error(err);
        });
    }

    function updateSongCount() {
        const songCount = document.querySelectorAll('.song-item[data-song-id]').length;
        document.getElementById('songCount').textContent = songCount;
    }

    document.querySelector('.save-button').addEventListener('click', function(e) {
        const remainingSongs = document.querySelectorAll('.song-item[data-song-id]').length;
        if (remainingSongs === 0) {
            e.preventDefault();
            alert('Cannot save an empty playlist. Please add at least one song.');
        }
    });

    function showAlert(message, type) {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;

        const container = document.querySelector('.main-title');
        container.parentNode.insertBefore(alert, container.nextSibling);

        setTimeout(() => alert.remove(), 5000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        window.csrfToken = token;
    });
</script>
</body>
</html>
