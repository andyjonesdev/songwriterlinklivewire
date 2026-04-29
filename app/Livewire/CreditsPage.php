<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app.sidebar')]
#[Title('Credits / CV')]
class CreditsPage extends Component
{
    public string $newTitle       = '';
    public string $newRole        = '';
    public string $newArtist      = '';
    public string $newYear        = '';
    public string $newLabel       = '';
    public string $newIsrc        = '';
    public string $newDescription = '';
    public bool   $showForm       = false;
    public ?int   $editingId      = null;

    protected function rules(): array
    {
        return [
            'newTitle'       => 'required|string|max:200',
            'newRole'        => 'required|string|max:100',
            'newArtist'      => 'nullable|string|max:200',
            'newYear'        => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'newLabel'       => 'nullable|string|max:200',
            'newIsrc'        => 'nullable|string|max:20',
            'newDescription' => 'nullable|string|max:500',
        ];
    }

    public function mount(): void
    {
        // Pro+ gate
        if (! Auth::user()->isProPlus()) {
            abort(403, 'Credits & CV export is a Pro+ feature.');
        }
    }

    public function openForm(?int $creditId = null): void
    {
        $this->resetForm();

        if ($creditId) {
            $credit = Auth::user()->credits()->findOrFail($creditId);
            $this->editingId      = $credit->id;
            $this->newTitle       = $credit->title;
            $this->newRole        = $credit->role;
            $this->newArtist      = $credit->artist ?? '';
            $this->newYear        = $credit->year    ? (string) $credit->year : '';
            $this->newLabel       = $credit->label   ?? '';
            $this->newIsrc        = $credit->isrc    ?? '';
            $this->newDescription = $credit->description ?? '';
        }

        $this->showForm = true;
    }

    public function saveCredit(): void
    {
        $data = $this->validate();

        $payload = [
            'title'       => $data['newTitle'],
            'role'        => $data['newRole'],
            'artist'      => $data['newArtist']      ?: null,
            'year'        => $data['newYear']         ? (int) $data['newYear'] : null,
            'label'       => $data['newLabel']        ?: null,
            'isrc'        => $data['newIsrc']         ?: null,
            'description' => $data['newDescription']  ?: null,
        ];

        if ($this->editingId) {
            Auth::user()->credits()->where('id', $this->editingId)->update($payload);
        } else {
            Auth::user()->credits()->create($payload);
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function deleteCredit(int $creditId): void
    {
        Auth::user()->credits()->where('id', $creditId)->delete();
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->newTitle       = '';
        $this->newRole        = '';
        $this->newArtist      = '';
        $this->newYear        = '';
        $this->newLabel       = '';
        $this->newIsrc        = '';
        $this->newDescription = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.credits-page', [
            'credits' => Auth::user()->credits()->orderByDesc('year')->orderBy('title')->get(),
            'profile' => Auth::user()->profile,
        ]);
    }
}
