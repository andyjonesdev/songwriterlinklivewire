<div class="mx-auto max-w-3xl space-y-6">

    @push('meta')
        @php
            $ogTitle       = $profile->display_name . ' — SongwriterLink';
            $userRole      = $profile->user->role ?? null;
            $ogDescription = $profile->bio
                ? \Illuminate\Support\Str::limit(strip_tags($profile->bio), 160)
                : ($userRole
                    ? ucfirst($userRole) . ' on SongwriterLink — The verified professional network for songwriters, composers and producers.'
                    : 'SongwriterLink — The verified professional network for songwriters, composers and producers.');
            $ogImage = $profile->profile_photo_path
                ? \Illuminate\Support\Facades\Storage::url($profile->profile_photo_path)
                : null;

            // Build JSON-LD in PHP to avoid @if inside <script> blocks
            $jsonLd = [
                '@context'    => 'https://schema.org',
                '@type'       => 'Person',
                'name'        => $profile->display_name,
                'url'         => url()->current(),
                'jobTitle'    => ucfirst($userRole ?? ''),
                'description' => $ogDescription,
            ];
            if ($ogImage) {
                $jsonLd['image'] = $ogImage;
            }
            if (!empty($profile->location)) {
                $jsonLd['address'] = [
                    '@type'           => 'PostalAddress',
                    'addressLocality' => $profile->location,
                ];
            }
        @endphp
        <meta name="description"         content="{{ $ogDescription }}" />
        <meta property="og:title"        content="{{ $ogTitle }}" />
        <meta property="og:description"  content="{{ $ogDescription }}" />
        <meta property="og:type"         content="profile" />
        @if($ogImage)
            <meta property="og:image"  content="{{ $ogImage }}" />
            <meta name="twitter:card"  content="summary_large_image" />
            <meta name="twitter:image" content="{{ $ogImage }}" />
        @else
            <meta name="twitter:card"  content="summary" />
        @endif
        <meta name="twitter:title"       content="{{ $ogTitle }}" />
        <meta name="twitter:description" content="{{ $ogDescription }}" />
        <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endpush

        @if(session('error'))
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        {{-- Profile header card --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-6">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start">

                {{-- Avatar --}}
                @if($profile->profile_photo_path)
                    <img src="{{ Storage::url($profile->profile_photo_path) }}"
                         alt="{{ $profile->display_name }}"
                         class="h-24 w-24 shrink-0 rounded-full object-cover ring-4 ring-zinc-100 sm:h-28 sm:w-28" />
                @else
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-violet-100 text-3xl font-bold text-violet-700 sm:h-28 sm:w-28">
                        {{ strtoupper(substr($profile->display_name, 0, 1)) }}
                    </div>
                @endif

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-2xl font-bold text-zinc-900">{{ $profile->display_name }}</h1>

                        {{-- Verified badge --}}
                        @if($profile->user->id_verified)
                            <span class="inline-flex items-center gap-1 rounded-full bg-violet-100 px-2 py-0.5 text-xs font-semibold text-violet-700">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                ID Verified
                            </span>
                        @endif

                        {{-- Pro badge --}}
                        @if($profile->user->isPro())
                            <span class="rounded-full bg-violet-600 px-2 py-0.5 text-xs font-semibold text-white">
                                {{ $profile->user->isProPlus() ? 'Pro+' : 'Pro' }}
                            </span>
                        @endif

                        {{-- Producer / Publisher badge --}}
                        @if($profile->user->producer_verified)
                            <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Producer</span>
                        @endif
                        @if($profile->user->publisher_verified)
                            <span class="rounded-full bg-sky-100 px-2 py-0.5 text-xs font-semibold text-sky-700">Publisher</span>
                        @endif
                    </div>

                    <p class="mt-1 text-sm font-medium text-zinc-500 capitalize">{{ $profile->user->role }}</p>

                    @if($profile->location || $profile->country)
                        <div class="mt-1.5 flex items-center gap-1 text-sm text-zinc-400">
                            <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ collect([$profile->location, $profile->country])->filter()->implode(', ') }}
                        </div>
                    @endif

                    {{-- Stats --}}
                    <div class="mt-3 flex items-center gap-4 text-xs text-zinc-400">
                        <span>{{ number_format($profile->connections_count) }} {{ Str::plural('connection', $profile->connections_count) }}</span>
                        <span>{{ number_format($profile->views_count) }} profile views</span>
                    </div>

                    {{-- Action buttons --}}
                    @auth
                        @if($connectionStatus !== 'own')
                            <div class="mt-4 flex flex-wrap gap-2">
                                {{-- Connect / Connection state --}}
                                @if($connectionStatus === 'none')
                                    <button wire:click="sendConnectionRequest"
                                            class="flex items-center gap-1.5 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                        Connect
                                    </button>
                                @elseif($connectionStatus === 'pending_sent')
                                    <button wire:click="removeConnection"
                                            class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-500 hover:border-red-200 hover:text-red-600 transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Request sent
                                    </button>
                                @elseif($connectionStatus === 'pending_received')
                                    <button wire:click="acceptConnection"
                                            class="flex items-center gap-1.5 rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Accept request
                                    </button>
                                    <button wire:click="removeConnection"
                                            class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-500 hover:border-red-200 hover:text-red-600 transition">
                                        Decline
                                    </button>
                                @elseif($connectionStatus === 'connected')
                                    <span class="flex items-center gap-1.5 rounded-lg border border-green-200 bg-green-50 px-4 py-2 text-sm font-medium text-green-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Connected
                                    </span>
                                    <button wire:click="removeConnection"
                                            class="rounded-lg border border-zinc-200 px-3 py-2 text-xs text-zinc-400 hover:border-red-200 hover:text-red-500 transition">
                                        Remove
                                    </button>
                                @endif

                                {{-- Message button --}}
                                <button wire:click="startMessage"
                                        class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:border-zinc-300 hover:bg-zinc-50 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Message
                                </button>
                            </div>
                            {{-- Report --}}
                            <div class="mt-2">
                                <livewire:report-user :reported-user-id="$profile->user_id" :key="'report-'.$profile->user_id" />
                            </div>
                        @else
                            {{-- Own profile: edit links --}}
                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('onboarding.step', 5) }}" wire:navigate
                                   class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit profile
                                </a>
                                <a href="{{ route('portfolio.index') }}" wire:navigate
                                   class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    Manage portfolio
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="mt-4">
                            <a href="{{ route('login') }}"
                               class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                                Sign in to connect
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Bio --}}
        @if($profile->bio)
            <div class="rounded-xl border border-zinc-200 bg-white p-6">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-400">About</h2>
                <p class="whitespace-pre-line text-sm leading-relaxed text-zinc-700">{{ $profile->bio }}</p>
            </div>
        @endif

        {{-- Genres --}}
        @if($profile->genres)
            <div class="rounded-xl border border-zinc-200 bg-white p-6">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-400">Genres</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($profile->genres as $genre)
                        <span class="rounded-full border border-violet-200 bg-violet-50 px-3 py-1 text-xs font-medium text-violet-700">{{ $genre }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Social & professional links --}}
        @if($profile->social_links && array_filter($profile->social_links))
            <div class="rounded-xl border border-zinc-200 bg-white p-6">
                <h2 class="mb-3 text-sm font-semibold uppercase tracking-wide text-zinc-400">Links</h2>

                @if($canSeeSocialLinks)
                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        @php
                            $linkLabels = [
                                'spotify'    => ['label' => 'Spotify', 'icon' => 'M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4.586 14.424a.622.622 0 01-.857.207c-2.348-1.435-5.304-1.76-8.785-.964a.622.622 0 01-.277-1.215c3.809-.87 7.076-.496 9.712 1.115a.623.623 0 01.207.857zm1.224-2.722a.78.78 0 01-1.072.258c-2.687-1.652-6.785-2.13-9.965-1.166a.782.782 0 01-.967-.519.781.781 0 01.519-.966c3.632-1.102 8.147-.568 11.227 1.32a.78.78 0 01.258 1.073zm.105-2.835c-3.223-1.914-8.54-2.09-11.618-1.156a.935.935 0 11-.542-1.79c3.532-1.072 9.404-.866 13.115 1.337a.935.935 0 01-.955 1.609z'],
                                'soundcloud' => ['label' => 'SoundCloud', 'icon' => 'M11.56 8.87V17h8.76c.96 0 1.68-.68 1.68-1.56 0-.78-.56-1.44-1.3-1.55a2.93 2.93 0 000-.07c0-1.4-1.17-2.53-2.62-2.53-.16 0-.31.02-.46.04A3.82 3.82 0 0013.94 9c-.3 0-.59.05-.86.14-.68-1.27-2.04-2.14-3.62-2.14a4.08 4.08 0 00-4.08 4.08c0 .34.04.67.11.99C4.51 12.39 3.5 13.52 3.5 14.87c0 1.18.78 2.13 1.79 2.13'],
                                'imdb'       => ['label' => 'IMDB', 'icon' => 'M5.5 5a.5.5 0 00-.5.5v13a.5.5 0 00.5.5h13a.5.5 0 00.5-.5v-13a.5.5 0 00-.5-.5h-13z'],
                                'linkedin'   => ['label' => 'LinkedIn', 'icon' => 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                                'prs_ascap'  => ['label' => 'PRS / ASCAP', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                                'discogs'    => ['label' => 'Discogs', 'icon' => 'M12 2a10 10 0 100 20A10 10 0 0012 2zm0 3a7 7 0 110 14A7 7 0 0112 5zm0 3a4 4 0 100 8 4 4 0 000-8zm0 2a2 2 0 110 4 2 2 0 010-4z'],
                            ];
                        @endphp
                        @foreach($profile->social_links as $key => $url)
                            @if($url && isset($linkLabels[$key]))
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                   class="flex items-center gap-2.5 rounded-lg border border-zinc-100 px-3 py-2 text-sm text-zinc-700 hover:border-zinc-200 hover:bg-zinc-50 transition">
                                    <svg class="h-4 w-4 shrink-0 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    {{ $linkLabels[$key]['label'] }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="flex items-start gap-3 rounded-lg border border-zinc-100 bg-zinc-50 px-4 py-3">
                        <svg class="h-4 w-4 mt-0.5 shrink-0 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <p class="text-xs text-zinc-500">
                            Social links are visible to Pro+ members and connections.
                            @auth
                                <a href="{{ route('onboarding.step', 8) }}" class="font-medium text-violet-600 hover:underline">Upgrade to Pro+</a> or connect with this member to see their links.
                            @else
                                <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:underline">Sign in</a> to connect.
                            @endauth
                        </p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Portfolio --}}
        @if($portfolioItems->count())
            <div class="rounded-xl border border-zinc-200 bg-white p-6">
                <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-zinc-400">Portfolio</h2>
                <div class="space-y-3">
                    @foreach($portfolioItems as $item)
                        <div class="flex items-center gap-3 rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white border border-zinc-200">
                                @if($item->type === 'audio')
                                    <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                @else
                                    <svg class="h-4 w-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="truncate text-sm font-medium text-zinc-900">{{ $item->title }}</p>
                                @if($item->description)
                                    <p class="truncate text-xs text-zinc-400">{{ $item->description }}</p>
                                @endif
                            </div>
                            @if($item->type === 'audio')
                                <audio controls class="h-8 max-w-48 shrink-0" preload="none">
                                    <source src="{{ Storage::url($item->file_path) }}" />
                                </audio>
                            @else
                                <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                   class="shrink-0 rounded-lg border border-zinc-200 px-3 py-1 text-xs font-medium text-zinc-600 hover:bg-zinc-100 transition">
                                    View
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

</div>
