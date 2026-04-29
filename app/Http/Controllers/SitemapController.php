<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        // Only include active, verified, searchable profiles
        $profiles = Profile::query()
            ->select(['slug', 'updated_at'])
            ->whereHas('user', fn ($q) => $q->where('status', 'active')->where('id_verified', true))
            ->where('is_searchable', true)
            ->orderByDesc('updated_at')
            ->get();

        $staticPages = [
            ['url' => url('/'),                        'priority' => '1.0',  'changefreq' => 'weekly'],
            ['url' => url('/members'),                 'priority' => '0.9',  'changefreq' => 'daily'],
            ['url' => url('/privacy'),                 'priority' => '0.3',  'changefreq' => 'yearly'],
            ['url' => url('/terms'),                   'priority' => '0.3',  'changefreq' => 'yearly'],
        ];

        $xml = view('sitemap', [
            'staticPages' => $staticPages,
            'profiles'    => $profiles,
        ])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
