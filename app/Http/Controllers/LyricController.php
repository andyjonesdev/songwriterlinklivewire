<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lyric;
use App\Models\LyricPromote;
use App\Models\Blog;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;
use Carbon\Carbon;

class LyricController extends Controller
{
    public function welcome()
    {
        // $lyrics = Lyric::where('status', 'published')
        //     ->latest()
        //     ->take(12)
        //     ->get()
        //     ->map(function ($lyric) {
        //         return [
        //             'id' => $lyric->id,
        //             'title' => $lyric->title,
        //             'genre' => $lyric->genre,
        //             'price' => $lyric->price,
        //             'mood' => $lyric->mood,
        //             'theme' => $lyric->theme,
        //             'pov' => $lyric->pov,
        //             'language' => $lyric->language,
        //             'slug' => $lyric->slug,
        //             'content' => $lyric->content,
        //             'status' => $lyric->status,
        //             'snippet' => Str::limit($lyric->content, 250),
        //             'created_at' => $lyric->created_at,
        //             'user' => $lyric->user ? $lyric->user->name : null, // user's name
        //             'user_profile' => $lyric->user 
        //                 ? route('profile.show', $lyric->user->id)
        //                 : null,
        //         ];
        //     });

        $lyrics = Lyric::where('status','published')->latest()->take(9)->get();
        $blogs = Blog::where('status','published')->latest()->take(3)->get();

        return view('welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'lyrics' => $lyrics,
            'blogs' => $blogs,
            'meta' => [
                'title' => 'Songwriter Link: Buy and Sell Original Song Lyrics',
                'description' => 'Discover Fresh, Original Song Lyrics for Your Next Music Project. Browse the world’s leading catalogue of high-quality lyrics, crafted by professional songwriters.',
            ],
        ]);
    }
    public function buyLyrics(Request $request)
    {
        // $lyrics = Lyric::where('status', 'published')
        // ->when($request->genre, fn ($q) => $q->where('genre', $request->genre))
        // ->when($request->mood, fn ($q) => $q->where('mood', $request->mood))
        // ->when($request->theme, fn ($q) => $q->where('theme', $request->theme))
        // ->when($request->pov, fn ($q) => $q->where('pov', $request->pov))
        // ->when($request->language, fn ($q) => $q->where('language', $request->language))
        // ->latest()
        // ->paginate(12)
        // ->withQueryString();

        $lyrics = Lyric::where('status', 'published')
        ->when($request->genre, fn ($q) => $q->where('genre', $request->genre))
        ->when($request->mood, fn ($q) => $q->where('mood', $request->mood))
        ->when($request->theme, fn ($q) => $q->where('theme', $request->theme))
        ->when($request->pov, fn ($q) => $q->where('pov', $request->pov))
        ->where('language', $request->language ?? 'english') // 👈 default
        ->with('user')
        ->when(auth()->check(), function ($q) {
            $q->withExists([
                'savedByUsers as is_saved' => fn ($sq) =>
                    $sq->where('user_id', auth()->id())
            ]);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(12)
        ->withQueryString();


        // $lyrics_promoted = LyricPromote::where('expiry_date', '>', Carbon::now())
        // ->with('user', 'lyric') // writer
        // ->orderBy('expiry_date', 'desc')
        // ->get();

        $genre = $request->genre;

        if ($genre=='All' || $genre=='') {
            $lyrics_promoted = Lyric::whereHas('promotions', function ($q) {
                $q->where('ends_at', '>=', now())
                ->where('placement', 'all');
            })->withMax(['promotions as max_bid' => function ($q) {
                $q->where('ends_at', '>=', now())
                ->where('placement', 'all');
            }],'bid')
            ->orderByDesc('max_bid')
            ->get();
        }
        else {
            $lyrics_promoted = Lyric::whereHas('promotions', function ($q) use ($genre) {
                $q->where('ends_at', '>=', now())
                ->where(function ($q) use ($genre) {
                    $q->where('placement', 'all')      // global promotion
                        ->orWhere('placement', $genre); // genre-specific
                });
            })
            ->withMax(['promotions as max_bid' => function ($q) use ($genre) {
                $q->where('ends_at', '>=', now())
                ->where(function ($q) use ($genre) {
                    $q->where('placement', 'all')
                        ->orWhere('placement', $genre);
                });
            }], 'bid')
            ->orderByDesc('max_bid')
            ->get();
        }

        // } else {
        //     $lyrics_promoted = Lyric::whereHas('promotions', function ($q) {
        //         $q->where('ends_at', '>=', now())
        //         ->where('placement', 'all');
        //     })->withMax(['promotions as max_bid' => function ($q) {
        //         $q->where('ends_at', '>=', now())
        //         ->where('placement', 'all');
        //     }],'bid')
        //     ->orderByDesc('max_bid')
        //     ->get();
        // }

        $base = Lyric::where('status', 'published');

        return view('buy', [
            'lyrics' => $lyrics,
            'lyrics_promoted' => $lyrics_promoted,
            'genre' => $genre,

            'genres' => (clone $base)
                ->whereNotNull('genre')
                ->where('genre', '!=', '')
                ->distinct()
                ->orderBy('genre')
                ->pluck('genre'),

            'moods' => (clone $base)
                ->whereNotNull('mood')
                ->where('mood', '!=', '')
                ->distinct()
                ->orderBy('mood')
                ->pluck('mood'),

            'themes' => (clone $base)
                ->whereNotNull('theme')
                ->where('theme', '!=', '')
                ->distinct()
                ->orderBy('theme')
                ->pluck('theme'),

            'povs' => (clone $base)
                ->whereNotNull('pov')
                ->where('pov', '!=', '')
                ->distinct()
                ->orderBy('pov')
                ->pluck('pov'),

            'languages' => (clone $base)
                ->whereNotNull('language')
                ->where('language', '!=', '')
                ->distinct()
                ->orderBy('language')
                ->pluck('language'),
        ]);
    }

    public function index(Request $request)
    {
        $lyrics = Lyric::where('status', 'published')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('lyrics.index', compact('lyrics'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'genre' => 'required|string|max:100',
            'price' => 'required|numeric',
            'mood' => 'required|string',
            'theme' => 'required|string',
            'pov' => 'required|string',
            'language' => 'required|string'
        ]);

        $lyric = auth()->user()->lyrics()->create($request->all());

        return redirect()->route('lyricsIndex')->with('success', 'Lyric uploaded!');
    }

    public function create()
    {
        return view('lyrics/create');
    }

    public function show(Lyric $lyric)
    {
        // Load the user relationship (only get the name)
        $lyric->load('user:id,name');
        $user = auth()->user();

        // return view('lyrics/Show', [
        //     'lyric' => [
        //         'id' => $lyric->id,
        //         'title' => $lyric->title,
        //         'content' => $lyric->content,
        //         'slug' => $lyric->slug,
        //         'status' => $lyric->status,
        //         'genre' => $lyric->genre,
        //         'price' => $lyric->price,
        //         'mood' => $lyric->mood,
        //         'theme' => $lyric->theme,
        //         'pov' => $lyric->pov,
        //         'language' => $lyric->language,
        //         'created_at' => $lyric->created_at,
        //         'user' => $lyric->user ? $lyric->user->name : null, // user's name
        //     ],
        //     'user' => $user,
        //     'meta' => [
        //         'title' => $lyric->title . ' - Songwriter Link Original Song Lyrics',
        //         'description' => 'Song Lyrics by ' . $lyric->user->name,
        //     ],
        // ]);

        return view('lyrics.show', [
            'lyric' => $lyric,
            'user' => auth()->user(),
            'meta' => [
                'title' => $lyric->title,
                'description' => Str::limit(strip_tags($lyric->content), 160),
            ],
        ]);

    }
    public function edit(Lyric $lyric)
    {
        return view('lyrics/Edit', [
            'lyric' => $lyric
        ]);
    }

    public function update(Request $request, Lyric $lyric)
    {
        $validated = $request->validate([
            'title'   => 'required',
            'genre'   => 'required',
            'content' => 'required',
            'price'   => 'required|numeric',
            'mood' => 'required|string',
            'theme' => 'required|string',
            'pov' => 'required|string',
            'language' => 'required|string'
        ]);

        $lyric->update($validated);

        // return redirect()->route('lyricsShow', $lyric->slug);
    }

    public function destroy(Lyric $lyric)
    {
        $lyric->delete();
        return redirect()->route('lyrics.index');
    }

    public function success()
    {
        return view('success');
    }

    public function favorite(Lyric $lyric)
    {
        $user = auth()->user();

        $user->savedLyrics()->syncWithoutDetaching($lyric->id);

        return back()->with('success', 'Lyric saved');
    }

    public function destroyFavorite(Lyric $lyric)
    {
        auth()->user()->savedLyrics()->detach($lyric->id);

        return back()->with('success', 'Lyric removed from saved list');
    }

    public function promote(Lyric $lyric)
    {
        return view('lyrics.promote', compact('lyric'));
    }

    public function topromote()
    {
        $lyrics = Lyric::where('status', 'published')
        ->where(function ($query) {
            $query->where('social_used', 0)   // not used
                ->orWhereNull('social_used'); // handle nulls
        })
        ->whereHas('user', function ($query) {
            $query->where('allow_social_use', 1);
        })
        ->with('user:id,name') // load only what you need
        ->latest()
        ->paginate(10);

        return view('lyrics.topromote', compact('lyrics'));
    }
    
    public function markUsed(Request $request, Lyric $lyric)
    {
        $lyric->update([
            'social_used' => $request->boolean('social_used')
        ]);

        return response()->json(['success' => true]);
    }

}
