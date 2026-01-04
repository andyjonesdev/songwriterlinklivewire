<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        return view('blog', [
            'blogs' => Blog::where('status','published')->latest()->paginate(9),
            'meta' => [
                'title' => 'Blog',
                'description' => 'Latest blog articles',
            ],
        ]);
    }

    public function show(Blog $blog)
    {
        return view('blog.show', [
            'blog' => $blog,
            'meta' => [
                'title' => $blog->title,
                'description' => $blog->description,
            ],
        ]);
    }

}
