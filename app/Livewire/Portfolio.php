<?php

namespace App\Livewire;

use App\Models\PortfolioItem;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class Portfolio extends Component
{
    use WithFileUploads;

    public string $type        = 'audio';
    public string $title       = '';
    public string $description = '';
    public bool   $isPublic    = true;
    public $file = null;

    public bool $showForm = false;

    public function toggleForm(): void
    {
        $this->showForm = ! $this->showForm;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->title       = '';
        $this->description = '';
        $this->isPublic    = true;
        $this->file        = null;
        $this->type        = 'audio';
        $this->resetValidation();
    }

    public function save(): void
    {
        $user = auth()->user();

        // Enforce free-tier limit of 3 items
        if (! $user->isPro()) {
            $count = PortfolioItem::where('user_id', $user->id)->count();
            if ($count >= 3) {
                $this->addError('file', 'Free accounts can upload up to 3 portfolio items. Upgrade to Pro for unlimited uploads.');
                return;
            }
        }

        // Dynamic validation rules based on type
        $fileRules = $this->type === 'audio'
            ? 'required|file|mimes:mp3,wav,aac,m4a,ogg|max:51200'  // 50 MB
            : 'required|file|mimes:pdf,txt,doc,docx|max:5120';       // 5 MB

        $this->validate([
            'title'       => 'required|string|max:120',
            'description' => 'nullable|string|max:500',
            'type'        => 'required|in:audio,lyrics',
            'file'        => $fileRules,
        ]);

        $folder = "portfolio/user_{$user->id}";
        $path   = $this->file->store($folder, 'public');
        $size   = $this->file->getSize();

        PortfolioItem::create([
            'user_id'     => $user->id,
            'type'        => $this->type,
            'title'       => $this->title,
            'description' => $this->description,
            'file_path'   => $path,
            'file_size'   => $size,
            'is_public'   => $this->isPublic,
        ]);

        $this->showForm = false;
        $this->resetForm();
        session()->flash('status', 'Portfolio item uploaded successfully.');
    }

    public function toggleVisibility(int $itemId): void
    {
        $item = PortfolioItem::where('user_id', auth()->id())->findOrFail($itemId);
        $item->update(['is_public' => ! $item->is_public]);
    }

    public function delete(int $itemId): void
    {
        $item = PortfolioItem::where('user_id', auth()->id())->findOrFail($itemId);
        Storage::disk('public')->delete($item->file_path);
        $item->delete();
        session()->flash('status', 'Item deleted.');
    }

    public function render()
    {
        $user   = auth()->user();
        $items  = PortfolioItem::where('user_id', $user->id)->latest()->get();
        $limit  = $user->isPro() ? null : 3;
        $count  = $items->count();
        $atLimit = $limit !== null && $count >= $limit;

        return view('livewire.portfolio', compact('items', 'limit', 'count', 'atLimit'));
    }
}
