<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionRenewalReminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiredSubscriptions extends Command
{
    protected $signature   = 'app:check-expired-subscriptions';
    protected $description = 'Downgrade expired subscriptions to free and send renewal reminder emails at 14 and 3 days before expiry.';

    public function handle(): void
    {
        $this->downgradeExpired();
        $this->sendReminders(14);
        $this->sendReminders(3);
    }

    // ── Downgrade expired ─────────────────────────────────────────────────────

    private function downgradeExpired(): void
    {
        $expired = User::where('subscription_tier', '!=', 'free')
            ->whereNotNull('subscription_expires_at')
            ->where('subscription_expires_at', '<', now())
            ->get();

        foreach ($expired as $user) {
            $user->update([
                'subscription_tier'       => 'free',
                'subscription_expires_at' => null,
                'subscription_term'       => null,
            ]);

            $this->line("Downgraded user #{$user->id} ({$user->email}) to free.");
        }

        $this->info("Downgraded {$expired->count()} expired subscription(s).");
    }

    // ── Renewal reminders ─────────────────────────────────────────────────────

    private function sendReminders(int $daysAhead): void
    {
        // Exact date match — running daily means this fires exactly once per user per reminder.
        $targetDate = now()->addDays($daysAhead)->toDateString();

        $users = User::where('subscription_tier', '!=', 'free')
            ->whereNotNull('subscription_expires_at')
            ->whereDate('subscription_expires_at', $targetDate)
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(
                new SubscriptionRenewalReminder($user, $daysAhead)
            );

            $this->line("Queued {$daysAhead}-day reminder for user #{$user->id} ({$user->email}).");
        }

        $this->info("Queued {$users->count()} renewal reminder(s) for {$daysAhead} days.");
    }
}
