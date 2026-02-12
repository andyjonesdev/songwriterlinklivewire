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
        $lyrics = $this->getLyrics('Pop');
        return view('buy.pop', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyRap()
    {
        $lyrics = $this->getLyrics('Rap');
        return view('buy.rap', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyCountry()
    {
        $lyrics = $this->getLyrics('Country');
        return view('buy.country', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyRock()
    {
        $lyrics = $this->getLyrics('Rock');
        return view('buy.rock', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyIndie()
    {
        $lyrics = $this->getLyrics('Indie');
        return view('buy.indie', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyMetal()
    {
        $lyrics = $this->getLyrics('Metal');
        return view('buy.metal', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyRandB()
    {
        $lyrics = $this->getLyrics('R&B');
        return view('buy.randb', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buySingerSongwriter()
    {
        $lyrics = $this->getLyrics('Singer-Songwriter');
        return view('buy.singer-songwriter', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyJazz()
    {
        $lyrics = $this->getLyrics('Jazz');
        return view('buy.jazz', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyChristian()
    {
        $lyrics = $this->getLyrics('Christian');
        return view('buy.christian', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyFolk()
    {
        $lyrics = $this->getLyrics('Folk');
        return view('buy.folk', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyWorld()
    {
        $lyrics = $this->getLyrics('World');
        return view('buy.world', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buySoul()
    {
        $lyrics = $this->getLyrics('Soul');
        return view('buy.soul', [
            'lyrics' => $lyrics,
        ]);
    }

    public function buyReggae()
    {
        $lyrics = $this->getLyrics('Reggae');
        return view('buy.reggae', [
            'lyrics' => $lyrics,
        ]);
    }

    public function getLyrics($genre) {
        $lyrics = Lyric::where('status', 'published')
        ->when($genre, fn ($q) => $q->where('genre', $genre))
        ->with('user') // writer
        ->when(auth()->check(), function ($q) {
            $q->withExists([
                'savedByUsers as is_saved' => fn ($sq) =>
                    $sq->where('user_id', auth()->id())
            ]);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(6)
        ->withQueryString();
        return $lyrics;
    }

    public function lyricMarketPlace()
    {
        return view('pages.lyricmarketplace', [

        ]);
    }

    public function royaltyFreeLyrics()
    {
        return view('pages.royaltyfreelyrics', [

        ]);
    }

    public function buySongLyrics()
    {
        return view('pages.buysonglyrics', [

        ]);
    }

    public function standardLicenceTerms()
    {
        return view('pages.standardlicenseterms', [

        ]);
    }

    public function termsOfService()
    {
        return view('pages.termsofservice', [

        ]);
    }

    public function privacyPolicy()
    {
        return view('pages.privacypolicy', [

        ]);
    }
    
}
