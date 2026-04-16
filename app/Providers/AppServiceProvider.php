<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('access-admin', fn (User $user) => $user->is_admin);

        // Pro features
        Gate::define('upload-unlimited-portfolio', fn (User $user) => $user->isPro());
        Gate::define('view-profile-analytics',     fn (User $user) => $user->isPro());
        Gate::define('boost-search',               fn (User $user) => $user->isPro());

        // Pro+ features
        Gate::define('post-brief-free',            fn (User $user) => $user->isProPlus()); // Pro+ posts free; Free/Pro pay £7/post
        Gate::define('multiple-briefs-open',       fn (User $user) => $user->isProPlus()); // up to 5 open simultaneously; Free/Pro: 1 at a time
        Gate::define('applicant-pipeline-view',    fn (User $user) => $user->isProPlus()); // full shortlist/pipeline UI; others get basic list
        Gate::define('view-member-social-links',   fn (User $user) => $user->isProPlus()); // see linked Spotify/SoundCloud without opening a conversation
        Gate::define('bulk-message-brief-matches', fn (User $user) => $user->isProPlus()); // message multiple matched members at once
        Gate::define('instant-application-alerts', fn (User $user) => $user->isProPlus()); // immediate; others have 1-hour delay
    }
}
