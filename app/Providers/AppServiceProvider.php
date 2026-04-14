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

        Gate::define('upload-unlimited-portfolio', fn (User $user) => $user->isPro());
        Gate::define('post-brief-free', fn (User $user) => $user->isProPlus());
        Gate::define('view-profile-analytics', fn (User $user) => $user->isPro());
        Gate::define('boost-search', fn (User $user) => $user->isPro());
    }
}
