<?php

namespace App\Services;

use App\Models\Lyric;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CopyscapeChecker
{
    // Flag as plagiarised if word count match percentage >= this threshold
    const THRESHOLD = 20;

    /**
     * @throws \RuntimeException
     */
    public function check(Lyric $lyric): void
    {
        $username = config('services.copyscape.username');
        $apiKey   = config('services.copyscape.key');

        if (empty($username) || empty($apiKey)) {
            throw new \RuntimeException('COPYSCAPE_USERNAME or COPYSCAPE_API_KEY is not set in your .env file.');
        }

        // Copyscape recommends checking a representative excerpt to save credits.
        // We send the first 1000 characters of the lyrics.
        $textToCheck = mb_substr(strip_tags($lyric->content), 0, 1000);

        $response = Http::timeout(30)->asForm()->post('https://www.copyscape.com/api/', [
            'u' => $username,
            'k' => $apiKey,
            'o' => 'csearch',  // commercial search (checks live web)
            'e' => 'UTF-8',
            'c' => 3,          // return up to 3 matching results
            'f' => 'json',
            't' => $textToCheck,
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException("Copyscape API request failed (HTTP {$response->status()}): " . $response->body());
        }

        $data = $response->json();

        if (isset($data['error'])) {
            throw new \RuntimeException("Copyscape API error: " . $data['error']);
        }

        // No results means no matches found
        if (empty($data['result'])) {
            $lyric->update([
                'plagiarism_flagged'     => false,
                'plagiarism_match_url'   => null,
                'plagiarism_flag_reason' => null,
            ]);
            return;
        }

        // Find the best (highest percentage) match
        $best = collect($data['result'])->sortByDesc('percentmatched')->first();

        $percentMatched = (int) ($best['percentmatched'] ?? 0);
        $flagged        = $percentMatched >= self::THRESHOLD;

        $lyric->update([
            'plagiarism_flagged'     => $flagged,
            'plagiarism_match_url'   => $best['url'] ?? null,
            'plagiarism_flag_reason' => $flagged
                ? "{$percentMatched}% of submitted lyrics matched content found at: " . ($best['url'] ?? 'unknown source')
                : null,
        ]);
    }
}
