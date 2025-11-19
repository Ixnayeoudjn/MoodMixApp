<?php

namespace App\Services;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session as SpotifySession;

class SpotifyService
{
    /**
     * Create a SpotifyWebAPI instance using Client Credentials for app-level read-only access.
     */
    public function clientApi(): SpotifyWebAPI
    {
        $session = new SpotifySession(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret')
        );

        $session->requestCredentialsToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($session->getAccessToken());

        return $api;
    }

    /**
     * Return the first album image URL for a given track response or null.
     */
    public function firstAlbumImageUrl($track): ?string
    {
        return $track->album->images[0]->url ?? null;
    }

    /**
     * Build an authorize URL for user OAuth and persist a CSRF state token in session.
     */
    public function getAuthorizeUrl(array $scopes = [
        'playlist-modify-public',
        'playlist-modify-private',
    ]): string
    {
        $session = $this->userSession();

        $options = [
            'scope' => $scopes,
        ];

        // Store generated state in session for CSRF protection (if later validated)
        session(['spotify_state' => $session->generateState()]);

        return $session->getAuthorizeUrl($options);
    }

    /**
     * Handle OAuth callback, exchange code for tokens and store them in session.
     */
    public function handleCallback(string $code): void
    {
        $session = $this->userSession();
        $session->requestAccessToken($code);

        session([
            'spotify_access_token' => $session->getAccessToken(),
            'spotify_refresh_token' => $session->getRefreshToken(),
        ]);
    }

    /**
     * Get a user-authorized API instance. Refreshes the token automatically if needed.
     * Returns null if no tokens are available in session.
     */
    public function userApi(): ?SpotifyWebAPI
    {
        $accessToken = session('spotify_access_token');
        $refreshToken = session('spotify_refresh_token');

        if (!$accessToken || !$refreshToken) {
            return null;
        }

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        try {
            // Simple call to verify token validity
            $api->me();
        } catch (\SpotifyWebAPI\SpotifyWebAPIException $e) {
            if (stripos($e->getMessage(), 'access token expired') !== false || $e->getCode() === 401) {
                $session = $this->userSession();
                $session->refreshAccessToken($refreshToken);
                $accessToken = $session->getAccessToken();
                session(['spotify_access_token' => $accessToken]);
                $api->setAccessToken($accessToken);
            } else {
                throw $e;
            }
        }

        return $api;
    }

    /**
     * Create a playlist for the authenticated user and add tracks by URIs.
     * Returns the created playlist object from Spotify.
     */
    public function createPlaylistWithTracks(string $name, string $description, bool $public, array $uris)
    {
        $api = $this->userApi();
        if (!$api) {
            return null;
        }

        $userId = $api->me()->id;

        $playlist = $api->createPlaylist($userId, [
            'name' => $name,
            'description' => $description,
            'public' => $public,
        ]);

        $chunks = array_chunk(array_values(array_filter($uris)), 100);
        foreach ($chunks as $chunk) {
            if (!empty($chunk)) {
                $api->addPlaylistTracks($playlist->id, $chunk);
            }
        }

        return $playlist;
    }

    /**
     * Helper to fetch track information using app-level client credentials flow.
     */
    public function getTrackById(string $trackId)
    {
        $api = $this->clientApi();
        return $api->getTrack($trackId);
    }

    /**
     * Build a SpotifyWebAPI Session configured for user OAuth.
     */
    protected function userSession(): SpotifySession
    {
        return new SpotifySession(
            config('services.spotify.client_id'),
            config('services.spotify.client_secret'),
            config('services.spotify.redirect')
        );
    }
}
