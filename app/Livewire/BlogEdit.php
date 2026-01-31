<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;

class BlogEdit extends Component
{
    public Blog $blog;

    public $title;
    public $description;
    public $category;
    public $seo_genre;
    public $content;

    public $updated = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'category' => 'required|string',
        'seo_genre' => 'required|string',
        'content' => 'required|string',
    ];

    public function mount(Blog $blog)
    {
        $this->blog = $blog;

        $this->title = $blog->title;
        $this->description = $blog->description;
        $this->category = $blog->category;
        $this->seo_genre = $blog->seo_genre;
        $this->content = $blog->content;
    }

    public function submit()
    {
        $this->validate();

        $this->blog->update([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'seo_genre' => $this->seo_genre,
            'content' => $this->content,
        ]);

        $this->updated = true;
    }

    public function render()
    {
        return view('livewire.blog-edit');
    }
}
