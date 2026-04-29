<?php

namespace App\Livewire;

use App\Models\Report;
use App\Models\User;
use Livewire\Component;

class ReportUser extends Component
{
    public int  $reportedUserId;
    public bool $open   = false;

    public string $reason = '';
    public string $detail = '';
    public bool   $submitted = false;

    public array $reasons = [
        'fake_producer' => 'Fake or misrepresented credits',
        'payment_scam'  => 'Payment scam / fraud',
        'harassment'    => 'Harassment or abuse',
        'spam'          => 'Spam or unsolicited content',
        'other'         => 'Other',
    ];

    public function mount(int $reportedUserId): void
    {
        $this->reportedUserId = $reportedUserId;
    }

    public function submit(): void
    {
        $this->validate([
            'reason' => 'required|in:fake_producer,payment_scam,harassment,spam,other',
            'detail' => 'nullable|string|max:1000',
        ]);

        $reporter = auth()->user();

        if (! $reporter) return;
        if ($reporter->id === $this->reportedUserId) return;

        // Prevent duplicate reports
        $existing = Report::where('reporter_id', $reporter->id)
            ->where('reported_user_id', $this->reportedUserId)
            ->exists();

        if ($existing) {
            $this->submitted = true;
            $this->open = false;
            return;
        }

        Report::create([
            'reporter_id'      => $reporter->id,
            'reported_user_id' => $this->reportedUserId,
            'reason'           => $this->reason,
            'detail'           => $this->detail,
            'status'           => 'open',
        ]);

        // Increment report count; auto-suspend at 3 independent reports
        $reported = User::findOrFail($this->reportedUserId);
        $reported->increment('report_count');

        if ($reported->report_count >= 3 && $reported->status === 'active') {
            $reported->update([
                'status'           => 'suspended',
                'suspension_reason'=> 'Auto-suspended: reached 3 independent reports.',
            ]);

            \App\Models\VerificationLog::create([
                'user_id' => $reported->id,
                'event'   => 'account_suspended',
                'detail'  => ['reason' => 'auto_suspend_report_threshold'],
            ]);
        }

        $this->submitted = true;
        $this->open = false;
        $this->reason = '';
        $this->detail = '';
    }

    public function render()
    {
        return view('livewire.report-user');
    }
}
