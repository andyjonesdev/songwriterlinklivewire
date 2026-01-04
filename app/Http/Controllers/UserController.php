<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function show(User $user)
    {
        $lyrics = $user->lyrics()
        ->where('status', 'published')
        ->latest()
        ->get();
        return view('users.show', [
            'user' => $user,
            'lyrics' => $lyrics, // collection
            'meta' => [
                'title' => $user->name,
                'description' => $user->bio,
            ],
        ]);

    }
}
