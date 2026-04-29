<?php

namespace App\Livewire\Briefs;

use App\Models\Brief;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'My Briefs'])]
class BriefManage extends Component
{
    public function closeBrief(int $id): void
    {
        Brief::where('id', $id)->where('user_id', auth()->id())->update(['status' => 'closed']);
    }

    public function reopenBrief(int $id): void
    {
        Brief::where('id', $id)
            ->where('user_id', auth()->id())
            ->update(['status' => 'open', 'expires_at' => now()->addDays(60)]);
    }

    public function render()
    {
        $briefs = auth()->user()->briefs()
            ->withCount('applications')
            ->with(['applications:id,brief_id,status'])
            ->latest()
            ->get();

        $categories = BriefIndex::categories();

        return view('livewire.briefs.brief-manage', compact('briefs', 'categories'));
    }
}
