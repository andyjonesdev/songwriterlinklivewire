<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use App\Models\User;
use App\Models\VerificationLog;
use App\Notifications\AccountSuspended;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Admin — Reports'])]
class ReportQueue extends Component
{
    use WithPagination;

    public string $filter = 'open';
    public string $suspensionReason = '';

    public function suspendUser(int $reportId): void
    {
        $report = Report::with('reportedUser')->findOrFail($reportId);
        $user   = $report->reportedUser;

        $reason = $this->suspensionReason ?: "Suspended following review of a report.";

        $user->update([
            'status'           => 'suspended',
            'suspension_reason'=> $reason,
        ]);

        $report->update(['status' => 'actioned']);

        // Mark all open reports against this user as actioned
        Report::where('reported_user_id', $user->id)
            ->where('status', 'open')
            ->update(['status' => 'actioned']);

        VerificationLog::create([
            'user_id' => $user->id,
            'event'   => 'account_suspended',
            'detail'  => ['actioned_by' => auth()->id(), 'reason' => $reason],
        ]);

        $user->notify(new AccountSuspended($reason));
        $this->suspensionReason = '';
        $this->resetPage();
    }

    public function dismiss(int $reportId): void
    {
        Report::findOrFail($reportId)->update(['status' => 'dismissed']);
        $this->resetPage();
    }

    public function markReviewed(int $reportId): void
    {
        Report::findOrFail($reportId)->update(['status' => 'reviewed']);
        $this->resetPage();
    }

    public function render()
    {
        $reports = Report::with(['reporter.profile', 'reportedUser.profile'])
            ->when($this->filter !== 'all', fn ($q) => $q->where('status', $this->filter))
            ->latest()
            ->paginate(20);

        return view('livewire.admin.report-queue', compact('reports'));
    }
}
