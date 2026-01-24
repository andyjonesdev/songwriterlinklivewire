<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lyric;

class PageController extends Controller
{    
    public function faqs()
    {
        return view('faqs', [
            'meta' => [
                'title' => 'FAQs - SongwriterLink',
                'description' => 'Find out all you need to know to find success with SongwriterLink',
            ],
        ]);
    }
    public function contact()
    {
        return view('contact', [
            'meta' => [
                'title' => 'Contact us - SongwriterLink',
                'description' => 'Get in touch with the support team at SongwriterLink',
            ],
        ]);
    }
    public function buyPop()
    {
        $lyrics = Lyric::where('status', 'published')
        ->when('Pop', fn ($q) => $q->where('genre', 'Pop'))
        ->with('user') // writer
        ->when(auth()->check(), function ($q) {
            $q->withExists([
                'savedByUsers as is_saved' => fn ($sq) =>
                    $sq->where('user_id', auth()->id())
            ]);
        })
        // ->latest()
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->withQueryString();

        return view('buy.pop', [
            'lyrics' => $lyrics,
            'meta' => [
                'title' => 'Contact us - SongwriterLink',
                'description' => 'Get in touch with the support team at SongwriterLink',
            ],
        ]);
    }
}
