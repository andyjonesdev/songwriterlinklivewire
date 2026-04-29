<?php

namespace App\Livewire\Briefs;

use App\Models\Brief;
use App\Models\BriefApplication;
use App\Models\PortfolioItem;
use App\Notifications\BriefApplicationReceived;
use App\Notifications\BriefShortlisted;
use Livewire\Component;

class BriefShow extends Component
{
    public Brief $brief;
    public ?BriefApplication $myApplication = null;

    // Apply form
    public string $pitchText      = '';
    public ?int   $portfolioItemId = null;

    public function mount(Brief $brief): void
    {
        $this->brief = $brief->load(['user.profile', 'applications.applicant.profile', 'applications.portfolioItem']);

        if (auth()->check()) {
            $this->myApplication = BriefApplication::where('brief_id', $brief->id)
                ->where('applicant_id', auth()->id())
                ->first();
        }
    }

    // ── Apply ─────────────────────────────────────────────────────────────────

    public function apply(): void
    {
        $user = auth()->user();

        if (! $user || ! $user->isActive()) {
            $this->addError('pitchText', 'Your account must be active to apply.');
            return;
        }

        if ($this->brief->user_id === $user->id) {
            $this->addError('pitchText', 'You cannot apply to your own brief.');
            return;
        }

        if ($this->brief->status !== 'open' || ($this->brief->expires_at && $this->brief->expires_at->isPast())) {
            $this->addError('pitchText', 'This brief is no longer accepting applications.');
            return;
        }

        if ($this->myApplication) {
            $this->addError('pitchText', 'You have already applied to this brief.');
            return;
        }

        $this->validate([
            'pitchText'      => 'required|string|min:20|max:2000',
            'portfolioItemId' => 'nullable|integer|exists:portfolio_items,id',
        ]);

        if ($this->portfolioItemId) {
            $item = PortfolioItem::find($this->portfolioItemId);
            if (! $item || $item->user_id !== $user->id) {
                $this->addError('portfolioItemId', 'Invalid portfolio item.');
                return;
            }
        }

        $this->myApplication = BriefApplication::create([
            'brief_id'          => $this->brief->id,
            'applicant_id'      => $user->id,
            'pitch_text'        => $this->pitchText,
            'portfolio_item_id' => $this->portfolioItemId,
        ]);

        $this->brief->user?->notify(new BriefApplicationReceived($this->myApplication));

        $this->pitchText       = '';
        $this->portfolioItemId = null;
        session()->flash('status', 'Application submitted!');
        $this->brief->load(['applications.applicant.profile', 'applications.portfolioItem']);
    }

    // ── Poster actions ────────────────────────────────────────────────────────

    public function updateApplicationStatus(int $applicationId, string $status): void
    {
        abort_unless($this->brief->user_id === auth()->id(), 403);
        abort_unless(in_array($status, ['pending', 'shortlisted', 'rejected']), 422);

        $application = BriefApplication::where('id', $applicationId)
            ->where('brief_id', $this->brief->id)
            ->first();

        if ($application) {
            $application->update(['status' => $status]);

            if ($status === 'shortlisted') {
                $application->load('brief');
                $application->applicant?->notify(new BriefShortlisted($application));
            }
        }

        $this->brief->load(['applications.applicant.profile', 'applications.portfolioItem']);
    }

    public function closeBrief(): void
    {
        abort_unless($this->brief->user_id === auth()->id(), 403);
        $this->brief->update(['status' => 'closed']);
    }

    public function reopenBrief(): void
    {
        abort_unless($this->brief->user_id === auth()->id(), 403);
        $this->brief->update(['status' => 'open', 'expires_at' => now()->addDays(60)]);
    }

    // ── Render ────────────────────────────────────────────────────────────────

    public function render()
    {
        $isOwner = auth()->check() && auth()->id() === $this->brief->user_id;

        $myPortfolioItems = auth()->check()
            ? PortfolioItem::where('user_id', auth()->id())->latest()->get()
            : collect();

        return view('livewire.briefs.brief-show', compact('isOwner', 'myPortfolioItems'))
            ->layout('components.layouts.app', ['title' => $this->brief->title]);
    }
}
