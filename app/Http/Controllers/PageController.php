<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
