<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;

class BlogAdmin extends Component
{
    public function delete($blogId)
    {
        $blog = Blog::findOrFail($blogId);

        // Optional: authorize
        // $this->authorize('delete', $blog);

        $blog->delete();

        session()->flash('success', 'Blog post deleted.');
    }

    public function render()
    {
        return view('livewire.blog-admin', [
            'blogs' => Blog::latest()->paginate(10),
        ]);
    }
}
