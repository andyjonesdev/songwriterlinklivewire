<div class="mx-auto max-w-2xl space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900">Messages</h1>
        </div>

        @if($items->isEmpty())
            <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center">
                <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <p class="text-sm font-medium text-zinc-500">No conversations yet</p>
                <p class="text-xs text-zinc-400">Browse members and send a message to get started.</p>
                <a href="{{ route('members.index') }}" wire:navigate
                   class="mt-1 rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700 transition">
                    Browse members
                </a>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white divide-y divide-zinc-100">
                @foreach($items as $item)
                    @php $other = $item->other; @endphp
                    <a href="{{ route('messages.show', $item->conversation) }}" wire:navigate
                       class="flex items-center gap-3 px-4 py-3.5 hover:bg-zinc-50 transition-colors {{ $item->unread ? 'bg-violet-50/50' : '' }}">

                        {{-- Avatar --}}
                        @if($other?->profile?->profile_photo_path)
                            <img src="{{ Storage::url($other->profile->profile_photo_path) }}"
                                 alt="{{ $other->profile->display_name ?? $other->name }}"
                                 class="h-10 w-10 shrink-0 rounded-full object-cover" />
                        @else
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-bold text-violet-700">
                                {{ strtoupper(substr($other?->profile?->display_name ?? $other?->name ?? '?', 0, 1)) }}
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline justify-between gap-2">
                                <span class="truncate text-sm font-semibold text-zinc-900 {{ $item->unread ? '' : 'font-medium' }}">
                                    {{ $other?->profile?->display_name ?? $other?->name ?? 'Unknown member' }}
                                </span>
                                @if($item->latest)
                                    <span class="shrink-0 text-xs text-zinc-400">
                                        {{ $item->latest->created_at->diffForHumans(short: true) }}
                                    </span>
                                @endif
                            </div>
                            @if($item->latest)
                                <p class="mt-0.5 truncate text-xs text-zinc-500">
                                    @if($item->latest->sender_id === auth()->id()) You: @endif
                                    {{ $item->latest->body }}
                                </p>
                            @endif
                        </div>

                        {{-- Unread dot --}}
                        @if($item->unread)
                            <div class="h-2.5 w-2.5 shrink-0 rounded-full bg-violet-500"></div>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
</div>
