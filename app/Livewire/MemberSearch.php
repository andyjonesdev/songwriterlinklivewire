<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Members'])]
class MemberSearch extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $role = '';

    #[Url(history: true)]
    public string $genre = '';

    #[Url(history: true)]
    public string $country = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedRole(): void   { $this->resetPage(); }
    public function updatedGenre(): void  { $this->resetPage(); }
    public function updatedCountry(): void { $this->resetPage(); }

    public function clearFilters(): void
    {
        $this->search  = '';
        $this->role    = '';
        $this->genre   = '';
        $this->country = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Profile::query()
            ->with('user')
            ->whereHas('user', fn ($q) => $q->where('status', 'active')->where('id_verified', true))
            ->where('is_searchable', true)
            ->when($this->search, fn ($q) => $q->where(fn ($inner) =>
                $inner->where('display_name', 'LIKE', "%{$this->search}%")
                      ->orWhere('bio', 'LIKE', "%{$this->search}%")
                      ->orWhere('location', 'LIKE', "%{$this->search}%")
                      ->orWhere('country', 'LIKE', "%{$this->search}%")
            ))
            ->when($this->role, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('role', $this->role)))
            ->when($this->genre, fn ($q) => $q->whereJsonContains('genres', $this->genre))
            ->when($this->country, fn ($q) => $q->where('country', $this->country))
            ->orderByDesc('search_boost_weight')
            ->orderByDesc('connections_count')
            ->orderByDesc('views_count');

        $members  = $query->paginate(24);
        $total    = $query->toBase()->getCountForPagination();

        $countries = Profile::whereHas('user', fn ($q) => $q->where('status', 'active'))
            ->whereNotNull('country')
            ->where('country', '!=', '')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $genres = [
            'Pop','Rock','Hip-Hop / Rap','R&B / Soul','Country','Folk','Indie',
            'Electronic','Jazz','Classical','Gospel / Christian','Reggae','Metal',
            'Singer-Songwriter','World','Other',
        ];

        $roles = [
            'songwriter' => 'Songwriter',
            'composer'   => 'Composer',
            'producer'   => 'Producer',
            'publisher'  => 'Publisher',
            'other'      => 'Other',
        ];

        return view('livewire.member-search', compact('members', 'countries', 'genres', 'roles', 'total'));
    }
}
