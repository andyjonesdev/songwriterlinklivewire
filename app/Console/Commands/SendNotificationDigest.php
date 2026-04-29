<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\NotificationDigest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendNotificationDigest extends Command
{
    protected $signature   = 'app:send-notification-digest';
    protected $description = 'Send hourly notification digest emails to users with unread notifications';

    public function handle(): void
    {
        // Find active users who have unread notifications
        User::where('status', 'active')
            ->whereHas('unreadNotifications')
            ->each(function (User $user) {

                // Throttle: only send once per ~55 minutes per user
                $cacheKey = 'notif_digest:' . $user->id;

                if (Cache::has($cacheKey)) {
                    return;
                }

                $unread = $user->unreadNotifications()->latest()->take(10)->get();

                if ($unread->isEmpty()) {
                    return;
                }

                $user->notify(new NotificationDigest($unread));

                // Mark sent — TTL 55 minutes so we don't double-send within an hour
                Cache::put($cacheKey, true, now()->addMinutes(55));
            });

        $this->info('Notification digest run complete.');
    }
}
