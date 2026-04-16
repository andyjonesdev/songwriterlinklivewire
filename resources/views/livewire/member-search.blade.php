<x-layouts.app title="Members">
    <div class="space-y-6">

        {{-- Page header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900">Members</h1>
                <p class="mt-0.5 text-sm text-zinc-500">
                    {{ $total }} verified {{ Str::plural('member', $total) }}
                    @if($search || $role || $genre || $country) matching your filters @endif
                </p>
            </div>
        </div>

        {{-- Search + filters --}}
        <div class="flex flex-wrap items-end gap-3">
            <div class="relative min-w-64 flex-1">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="Search by name, bio, or location…"
                       class="w-full rounded-lg border border-zinc-200 bg-white py-2 pl-9 pr-4 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
            </div>

            <select wire:model.live="role"
                    class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                <option value="">All roles</option>
                @foreach($roles as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <select wire:model.live="genre"
                    class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                <option value="">All genres</option>
                @foreach($genres as $g)
                    <option value="{{ $g }}">{{ $g }}</option>
                @endforeach
            </select>

            <select wire:model.live="country"
                    class="rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100">
                <option value="">All countries</option>
                @foreach($countries as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>

            @if($search || $role || $genre || $country)
                <button wire:click="clearFilters"
                        class="flex items-center gap-1.5 rounded-lg border border-zinc-200 px-3 py-2 text-sm text-zinc-500 hover:border-zinc-300 hover:text-zinc-700 transition-colors">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Clear
                </button>
            @endif
        </div>

        {{-- Loading state --}}
        <div wire:loading.delay class="flex items-center gap-2 text-sm text-zinc-400">
            <svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            Searching…
        </div>

        {{-- Member grid --}}
        @if($members->count())
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($members as $profile)
                    @php $user = $profile->user; @endphp
                    <a href="{{ route('profile.show', $profile) }}"
                       class="group flex flex-col gap-3 rounded-xl border border-zinc-200 bg-white p-4 hover:border-violet-300 hover:shadow-sm transition-all">

                        {{-- Avatar --}}
                        <div class="flex items-center gap-3">
                            @if($profile->profile_photo_path)
                                <img src="{{ Storage::url($profile->profile_photo_path) }}"
                                     alt="{{ $profile->display_name }}"
                                     class="h-12 w-12 rounded-full object-cover ring-2 ring-zinc-100 group-hover:ring-violet-100 transition-all" />
                            @else
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700">
                                    {{ strtoupper(substr($profile->display_name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="truncate font-semibold text-zinc-900 text-sm">{{ $profile->display_name }}</span>
                                    @if($user->id_verified)
                                        <svg class="h-3.5 w-3.5 shrink-0 text-violet-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-xs text-zinc-400 capitalize">{{ $user->role }}</span>
                                    @if($user->isPro())
                                        <span class="rounded-full bg-violet-100 px-1.5 py-0.5 text-[10px] font-semibold text-violet-700">
                                            {{ $user->isProPlus() ? 'Pro+' : 'Pro' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Location --}}
                        @if($profile->location || $profile->country)
                            <div class="flex items-center gap-1 text-xs text-zinc-400">
                                <svg class="h-3 w-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ collect([$profile->location, $profile->country])->filter()->implode(', ') }}
                            </div>
                        @endif

                        {{-- Genres --}}
                        @if($profile->genres)
                            <div class="flex flex-wrap gap-1">
                                @foreach(array_slice($profile->genres, 0, 3) as $g)
                                    <span class="rounded-full border border-zinc-100 bg-zinc-50 px-2 py-0.5 text-[10px] text-zinc-500">{{ $g }}</span>
                                @endforeach
                                @if(count($profile->genres) > 3)
                                    <span class="text-[10px] text-zinc-400">+{{ count($profile->genres) - 3 }}</span>
                                @endif
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $members->links() }}
            </div>

        @else
            <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center">
                <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="text-sm text-zinc-500">No members found matching your search.</p>
                @if($search || $role || $genre || $country)
                    <button wire:click="clearFilters" class="text-sm font-medium text-violet-600 hover:underline">Clear filters</button>
                @endif
            </div>
        @endif
    </div>
</x-layouts.app>
