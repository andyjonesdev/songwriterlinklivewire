<?php

namespace App\Livewire\Briefs;

use App\Models\Brief;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Post a Brief'])]
class BriefCreate extends Component
{
    public string $title              = '';
    public string $description        = '';
    public string $category           = '';
    public array  $genres             = [];
    public string $compensationType   = '';
    public string $compensationDetail = '';
    public string $deadline           = '';

    public function mount(): void
    {
        if (! auth()->user()->isPro()) {
            session()->flash('error', 'You need a Pro or Pro+ subscription to post briefs.');
            $this->redirect(route('briefs.index'), navigate: true);
        }
    }

    public function save(): void
    {
        $user = auth()->user();

        if (! $user->isPro()) {
            $this->addError('title', 'Pro subscription required to post briefs.');
            return;
        }

        // Pro: max 3 open briefs; Pro+: unlimited
        if (! $user->isProPlus() && $user->briefs()->where('status', 'open')->count() >= 3) {
            $this->addError('title', 'Pro plan is limited to 3 open briefs at a time. Close one or upgrade to Pro+.');
            return;
        }

        $this->validate([
            'title'              => 'required|string|max:120',
            'description'        => 'required|string|min:50|max:3000',
            'category'           => 'required|in:co_writer,topline,sync_placement,ghost_write,session_lyricist',
            'genres'             => 'nullable|array|max:5',
            'compensationType'   => 'required|in:split,fee,spec',
            'compensationDetail' => 'nullable|string|max:255',
            'deadline'           => 'nullable|date|after:today',
        ]);

        $brief = Brief::create([
            'user_id'             => $user->id,
            'title'               => $this->title,
            'description'         => $this->description,
            'category'            => $this->category,
            'genres'              => $this->genres ?: null,
            'compensation_type'   => $this->compensationType,
            'compensation_detail' => $this->compensationDetail ?: null,
            'deadline'            => $this->deadline ?: null,
            'status'              => 'open',
            'expires_at'          => now()->addDays(60),
        ]);

        session()->flash('status', 'Brief posted successfully!');
        $this->redirect(route('briefs.show', $brief), navigate: true);
    }

    public function render()
    {
        return view('livewire.briefs.brief-create', [
            'categories'        => BriefIndex::categories(),
            'genres'            => BriefIndex::genres(),
            'compensationTypes' => BriefIndex::compensationTypes(),
        ]);
    }
}
