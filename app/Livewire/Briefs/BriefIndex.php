<?php

namespace App\Livewire\Briefs;

use App\Models\Brief;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Brief Board'])]
class BriefIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $category = '';

    #[Url(history: true)]
    public string $genre = '';

    #[Url(history: true)]
    public string $compensation = '';

    public function updatedSearch(): void      { $this->resetPage(); }
    public function updatedCategory(): void    { $this->resetPage(); }
    public function updatedGenre(): void       { $this->resetPage(); }
    public function updatedCompensation(): void { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->search       = '';
        $this->category     = '';
        $this->genre        = '';
        $this->compensation = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Brief::with('user.profile')
            ->withCount('applications')
            ->where('status', 'open')
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));

        if ($this->search) {
            $query->where(fn ($q) =>
                $q->where('title', 'LIKE', "%{$this->search}%")
                  ->orWhere('description', 'LIKE', "%{$this->search}%")
            );
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->genre) {
            $query->whereJsonContains('genres', $this->genre);
        }

        if ($this->compensation) {
            $query->where('compensation_type', $this->compensation);
        }

        $briefs = $query->latest()->paginate(12);
        $total  = Brief::where('status', 'open')
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->count();

        return view('livewire.briefs.brief-index', compact('briefs', 'total'));
    }

    public static function categories(): array
    {
        return [
            'co_writer'        => 'Co-writer',
            'topline'          => 'Topline',
            'sync_placement'   => 'Sync Placement',
            'ghost_write'      => 'Ghost Write',
            'session_lyricist' => 'Session Lyricist',
        ];
    }

    public static function compensationTypes(): array
    {
        return [
            'split' => 'Revenue Split',
            'fee'   => 'Fixed Fee',
            'spec'  => 'Spec',
        ];
    }

    public static function genres(): array
    {
        return ['Pop', 'Rock', 'R&B', 'Hip-Hop', 'Country', 'Electronic', 'Jazz', 'Classical',
                'Folk', 'Soul', 'Gospel', 'Latin', 'Metal', 'Indie', 'Alternative'];
    }
}
