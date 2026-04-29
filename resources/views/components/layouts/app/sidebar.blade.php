<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            @php
                // Unread message count for sidebar badge
                $unreadCount = 0;
                $unreadNotifCount = 0;
                if (auth()->check()) {
                    $userId = auth()->id();
                    $unreadCount = auth()->user()->conversations()
                        ->with(['latestMessage'])
                        ->get()
                        ->filter(function ($c) use ($userId) {
                            $latest = $c->latestMessage;
                            if (! $latest || $latest->sender_id === $userId) return false;
                            $lastRead = $c->participants->firstWhere('id', $userId)?->pivot->last_read_at;
                            return $lastRead === null || $latest->created_at->gt(\Carbon\Carbon::parse($lastRead));
                        })
                        ->count();
                    $unreadNotifCount = auth()->user()->unreadNotifications()->count();
                }
            @endphp

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="auth()->user()->name" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('members.index')" :current="request()->routeIs('members.*')" wire:navigate>
                        {{ __('Members') }}
                    </flux:navlist.item>
                    <flux:navlist.item icon="chat-bubble-left-right" :href="route('messages.index')" :current="request()->routeIs('messages.*')" wire:navigate>
                        <div class="flex items-center justify-between w-full">
                            <span>{{ __('Messages') }}</span>
                            @if($unreadCount > 0)
                                <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">
                                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                                </span>
                            @endif
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="bell" :href="route('notifications')" :current="request()->routeIs('notifications')" wire:navigate>
                        <div class="flex items-center justify-between w-full">
                            <span>{{ __('Notifications') }}</span>
                            @if($unreadNotifCount > 0)
                                <span class="flex h-5 min-w-5 items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">
                                    {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
                                </span>
                            @endif
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('briefs.index')" :current="request()->routeIs('briefs.index')" wire:navigate>
                        {{ __('Brief Board') }}
                    </flux:navlist.item>
                    @if(auth()->user()->isPro())
                        <flux:navlist.item icon="clipboard-document-list" :href="route('briefs.mine')" :current="request()->routeIs('briefs.mine')" wire:navigate>
                            {{ __('My Briefs') }}
                        </flux:navlist.item>
                    @endif
                    @if(auth()->user()->isProPlus())
                        <flux:navlist.item icon="chart-bar" :href="route('analytics')" :current="request()->routeIs('analytics')" wire:navigate>
                            {{ __('Analytics') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="document-chart-bar" :href="route('credits.index')" :current="request()->routeIs('credits.*')" wire:navigate>
                            {{ __('Credits / CV') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="document-duplicate" :href="route('split-sheet.index')" :current="request()->routeIs('split-sheet.*')" wire:navigate>
                            {{ __('Split Sheet') }}
                        </flux:navlist.item>
                    @endif
                    @if(auth()->user()->profile)
                        <flux:navlist.item icon="user-circle" :href="route('profile.show', auth()->user()->profile)" :current="request()->routeIs('profile.show')" wire:navigate>
                            {{ __('My Profile') }}
                        </flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="musical-note" :href="route('portfolio.index')" :current="request()->routeIs('portfolio.*')" wire:navigate>
                        {{ __('Portfolio') }}
                    </flux:navlist.item>
                </flux:navlist.group>

                @if(auth()->user()->is_admin)
                    <flux:navlist.group heading="Admin" class="grid">
                        <flux:navlist.item icon="shield-check" :href="route('admin.index')" :current="request()->routeIs('admin.*')" wire:navigate>
                            {{ __('Admin Panel') }}
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            <!-- Subscription badge -->
            @if(auth()->user()->isPro())
                <div class="mx-2 mb-2 rounded-lg bg-brand/10 px-3 py-2 text-xs font-medium text-brand dark:text-brand-light">
                    {{ auth()->user()->isProPlus() ? 'Pro+ Member' : 'Pro Member' }}
                </div>
            @endif

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        <flux:menu.item :href="route('settings.subscription')" icon="credit-card" wire:navigate>{{ __('Subscription') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile Header -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @fluxScripts
    </body>
</html>
