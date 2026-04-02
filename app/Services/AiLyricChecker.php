<?php

namespace App\Services;

use App\Models\Lyric;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiLyricChecker
{
    // Flag as suspected AI if confidence >= this threshold
    const THRESHOLD = 50;

    private string $prompt = <<<'PROMPT'
You are an expert at detecting AI-generated song lyrics. Analyse the lyrics below carefully and assess how likely they are to have been written by an AI system such as ChatGPT, Gemini, or Claude.

AI-generated lyrics typically show several of these traits:
- Overly consistent syllable counts and near-perfect meter throughout with no natural stumbles
- Flawlessly executed conventional rhyme schemes (ABAB, AABB) without any irregularity
- Generic, predictable emotional language ("heart aches", "tears fall", "love shines through")
- Smooth, polished transitions that feel assembled rather than felt
- Familiar clichéd metaphors used correctly but without genuine depth or surprise
- A "radio-ready" quality that feels optimised for structure rather than meaning
- Lack of truly unexpected, idiosyncratic, or awkward word choices
- Themes and imagery that are illustrative rather than personal or specific
- Every verse and chorus resolves neatly — no loose threads, no genuine ambiguity

Human-written lyrics often show:
- Irregular meter or syllable counts that feel natural but imperfect
- Unexpected imagery or unconventional word choices that feel like a real person's voice
- Personal specificity — references that feel genuinely lived-in
- Occasional awkward lines that still ring true
- Structural rule-breaking that serves the emotion

Score the lyrics 0–100 where:
  0  = almost certainly written by a human
  50 = genuinely uncertain
  100 = almost certainly AI-generated

Respond ONLY with a valid JSON object — no markdown fences, no explanation outside the JSON:
{"ai_confidence": <integer 0-100>, "ai_suspected": <boolean, true if ai_confidence >= 50>, "reason": "<one concise sentence>"}

Lyrics to analyse:

PROMPT;

    /**
     * @throws \RuntimeException
     */
    public function check(Lyric $lyric): void
    {
        $apiKey = config('services.anthropic.key');

        if (empty($apiKey)) {
            throw new \RuntimeException('ANTHROPIC_API_KEY is not set in your .env file.');
        }

        $response = Http::timeout(60)->withHeaders([
            'x-api-key'         => $apiKey,
            'anthropic-version' => '2023-06-01',
            'content-type'      => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model'      => 'claude-sonnet-4-6',
            'max_tokens' => 512,
            'messages'   => [
                [
                    'role'    => 'user',
                    'content' => $this->prompt . $lyric->content,
                ],
            ],
        ]);

        if (!$response->successful()) {
            throw new \RuntimeException("API request failed (HTTP {$response->status()}): " . $response->body());
        }

        $text = trim($response->json('content.0.text', ''));

        // Strip markdown code fences if the model wraps the JSON anyway
        $text = preg_replace('/^```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', trim($text));

        $data = json_decode($text, true);

        if (!is_array($data) || !array_key_exists('ai_confidence', $data)) {
            throw new \RuntimeException("Unexpected API response for lyric #{$lyric->id}: {$text}");
        }

        $confidence = (int) $data['ai_confidence'];

        $lyric->update([
            'ai_confidence'  => $confidence,
            'ai_flagged'     => $confidence >= self::THRESHOLD,
            'ai_flag_reason' => $data['reason'] ?? null,
        ]);
    }
}
