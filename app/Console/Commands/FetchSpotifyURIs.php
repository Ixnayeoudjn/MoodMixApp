<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use League\Csv\Reader;
use League\Csv\Writer;

class FetchSpotifyURIs extends Command
{
    protected $signature = 'spotify:fetch-uris {input=storage/app/songs.csv} {output=storage/app/songs_with_uris.csv}';
    protected $description = 'Fetch Spotify URIs for songs in CSV and save with URIs added.';

    public function handle()
    {
        $inputPath = base_path($this->argument('input'));
        $outputPath = base_path($this->argument('output'));

        $this->info("Reading input file: $inputPath");

        $csv = Reader::createFromPath($inputPath, 'r');
        $csv->setHeaderOffset(0);
        $records = iterator_to_array($csv->getRecords());

        // Auth
        $session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_REDIRECT_URI')
        );
        $session->requestCredentialsToken();
        $accessToken = $session->getAccessToken();

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $updatedRows = [];
        $notFoundCount = 0;

        foreach ($records as $i => $row) {
            $title = trim($row['Title']);
            $artist = trim($row['Artist'] ?? '');
            $year = trim($row['ActualYear'] ?? '');

            // Clean up title: remove parentheses and "feat."
            $cleanTitle = preg_replace('/\(.*?\)|\[.*?\]|feat\.|ft\.| - /i', '', $title);
            $cleanTitle = trim(preg_replace('/\s+/', ' ', $cleanTitle));

            $uri = $this->searchSpotify($api, $cleanTitle, $artist, $year);

            if (!$uri) {
                $uri = 'Not Found';
                $notFoundCount++;
            }

            $row['SpotifyURI'] = $uri;
            $updatedRows[] = $row;

            if (($i + 1) % 100 === 0) {
                $this->info("Processed " . ($i + 1) . " songs...");
            }

            usleep(150000); // 0.15s delay
        }

        $headers = array_keys($updatedRows[0]);
        $writer = Writer::createFromPath($outputPath, 'w+');
        $writer->insertOne($headers);
        $writer->insertAll($updatedRows);

        $this->info("✅ Done! Output written to: $outputPath");
        $this->warn("⚠️  {$notFoundCount} songs still not found.");
    }

    private function searchSpotify($api, $title, $artist, $year)
    {
        $queries = [
            "{$title} artist:{$artist} year:{$year}",   // strict
            "{$title} artist:{$artist}",                // drop year
            "{$title} {$artist}",                       // simple
            "{$title}",                                 // title only
        ];

        foreach ($queries as $query) {
            try {
                $results = $api->search($query, 'track', ['limit' => 1]);
                if (!empty($results->tracks->items)) {
                    return $results->tracks->items[0]->uri;
                }
            } catch (\Exception $e) {
                // Skip to next query
                continue;
            }
        }

        return null;
    }
}
