<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── Scheduled jobs ────────────────────────────────────────────────────────────

// Runs daily at 08:00. Downgrades expired Pro/Pro+ accounts to free and sends
// renewal reminder emails at 14 and 3 days before expiry.
Schedule::command('app:check-expired-subscriptions')->dailyAt('08:00');

// Runs hourly. Sends a digest email to users with unread notifications.
// A per-user cache key prevents duplicate sends within 55 minutes.
Schedule::command('app:send-notification-digest')->hourly();
