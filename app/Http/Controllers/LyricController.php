<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lyric;
use App\Models\Blog;
use Illuminate\Support\Str;
use Laravel\Fortify\Features;

class LyricController extends Controller
{
    public function welcome()
    {
        $lyrics = Lyric::where('status', 'published')
            ->latest()
            ->take(12)
            ->get()
            ->map(function ($lyric) {
                return [
                    'id' => $lyric->id,
                    'title' => $lyric->title,
                    'genre' => $lyric->genre,
                    'price' => $lyric->price,
                    'mood' => $lyric->mood,
                    'theme' => $lyric->theme,
                    'pov' => $lyric->pov,
                    'language' => $lyric->language,
                    'slug' => $lyric->slug,
                    'content' => $lyric->content,
                    'status' => $lyric->status,
                    'snippet' => Str::limit($lyric->content, 250),
                    'created_at' => $lyric->created_at,
                    'user' => $lyric->user ? $lyric->user->name : null, // user's name
                    'user_profile' => $lyric->user 
                        ? route('profile.show', $lyric->user->id)
                        : null,
                ];
            });

        $blogs = Blog::where('status', 'published')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($blog) {
                return [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'category' => $blog->category,
                    'slug' => $blog->slug,
                    'content' => $blog->content,
                    'status' => $blog->status,
                    'snippet' => Str::limit($blog->content, 250),
                    'created_at' => $blog->created_at,
                ];
            });


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
        $genre = $request->get('genre'); // example: ?genre=rap

        $lyrics = Lyric::query()
            ->where('status', 'published')                   // only approved
            ->when($genre, function ($query) use ($genre) { // filter by genre if provided
                $query->where('genre', $genre);
            })
            ->latest()
            ->paginate(24)
            ->withQueryString() // keeps ?genre=... during pagination
            ->through(function ($lyric) {
                return [
                    'id' => $lyric->id,
                    'title' => $lyric->title,
                    'genre' => $lyric->genre,
                    'price' => $lyric->price,
                    'mood' => $lyric->mood,
                    'theme' => $lyric->theme,
                    'pov' => $lyric->pov,
                    'language' => $lyric->language,
                    'slug' => $lyric->slug,
                    'content' => $lyric->content,
                    'status' => $lyric->status,
                    'snippet' => Str::limit($lyric->content, 250),
                    'created_at' => $lyric->created_at,
                    'user' => $lyric->user ? $lyric->user->name : null, // user's name
                    'user_profile' => $lyric->user 
                        ? route('profile.show', $lyric->user->id)
                        : null,
                ];
            });

        return view('buy', [
            'canRegister' => Features::enabled(Features::registration()),
            'lyrics' => $lyrics,
            'selectedGenre' => $genre,
            'meta' => [
                'title' => 'Buy Original Song Lyrics: Songwriter Link',
                'description' => 'Buy original song lyrics from professional writers. Browse unique, high-quality lyrics for all genres—perfect for your next music project.',
            ],
        ]);
    }

    public function index(Request $request)
    {
        $lyrics = Lyric::where('status', 'published')->where('user_id', auth()->id())
            ->get()
            ->map(function ($lyric) {
                return [
                    'id' => $lyric->id,
                    'title' => $lyric->title,
                    'genre' => $lyric->genre,
                    'price' => $lyric->price,
                    'mood' => $lyric->mood,
                    'theme' => $lyric->theme,
                    'pov' => $lyric->pov,
                    'language' => $lyric->language,
                    'slug' => $lyric->slug,
                    'content' => $lyric->content,
                    'status' => $lyric->status,
                    'snippet' => Str::limit($lyric->content, 150),
                ];
            });

        return view('lyrics/Index', [
            'lyrics' => $lyrics
        ]);
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
        return view('lyrics/Create');
    }

    public function show(Lyric $lyric)
    {
        // Load the user relationship (only get the name)
        $lyric->load('user:id,name');
        $user = auth()->user();

        return view('lyrics/Show', [
            'lyric' => [
                'id' => $lyric->id,
                'title' => $lyric->title,
                'content' => $lyric->content,
                'slug' => $lyric->slug,
                'status' => $lyric->status,
                'genre' => $lyric->genre,
                'price' => $lyric->price,
                'mood' => $lyric->mood,
                'theme' => $lyric->theme,
                'pov' => $lyric->pov,
                'language' => $lyric->language,
                'created_at' => $lyric->created_at,
                'user' => $lyric->user ? $lyric->user->name : null, // user's name
            ],
            'user' => $user,
            'meta' => [
                'title' => $lyric->title . ' - Songwriter Link Original Song Lyrics',
                'description' => 'Song Lyrics by ' . $lyric->user->name,
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
        return redirect()->route('lyricsIndex');
    }

    public function success()
    {
        return view('Success');
    }
}
