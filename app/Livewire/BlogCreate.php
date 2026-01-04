<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogCreate extends Component
{
    public $title = '';
    public $description = '';
    public $category = '';
    public $content = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'category' => 'required|string',
        'content' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        Blog::create([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'content' => $this->content,
            'slug' => Str::slug($this->title),
        ]);

        session()->flash('success', 'Blog uploaded successfully!');

        // Optional redirect after save
        return redirect()->route('blog.admin');
    }

    public function render()
    {
        return view('livewire.blog-create');
    }
}
