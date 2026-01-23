<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoodMix - Recommended Songs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/recommendation-results.css'])
</head>
<body>
    <div class="container fade-slide-in">
        <div class="header" style="display: flex">
            <img src="{{ asset('logo.png') }}" alt="MoodMix Logo" id="moodmixlogo"/>
            <a href="{{ url('/') }}" class="header-title" >MoodMix</a>
        </div>

        <h3 class="main-title">{{ $filters['mood_message'] ?? ('Here are some ' . ($filters['mood_name'] ?? 'Great') . ' songs for you') }}</h3>

        <form method="POST" action="{{ route('playlist.save') }}" class="playlist-form">
            @csrf
            <input type="hidden" name="mood" value="{{ $filters['mood'] }}">
            <input type="hidden" name="feeling" value="{{ $filters['feeling'] ?? '' }}">
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
