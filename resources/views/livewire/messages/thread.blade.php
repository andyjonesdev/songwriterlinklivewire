<x-layouts.app :title="'Messages — ' . ($other?->profile?->display_name ?? $other?->name ?? 'Conversation')">

    {{-- Poll for new messages every 5s --}}
    <div wire:poll.5s="loadMessages" class="mx-auto flex max-w-2xl flex-col" style="height: calc(100vh - 140px)">

        {{-- Header --}}
        <div class="mb-4 flex items-center gap-3">
            <a href="{{ route('messages.index') }}" wire:navigate
               class="flex items-center gap-1 text-sm text-zinc-400 hover:text-zinc-600 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Inbox
            </a>
            <span class="text-zinc-200">|</span>

            @if($other?->profile?->profile_photo_path)
                <img src="{{ Storage::url($other->profile->profile_photo_path) }}"
                     alt="" class="h-8 w-8 rounded-full object-cover" />
            @else
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-xs font-bold text-violet-700">
                    {{ strtoupper(substr($other?->profile?->display_name ?? $other?->name ?? '?', 0, 1)) }}
                </div>
            @endif

            <a href="{{ $other?->profile ? route('profile.show', $other->profile) : '#' }}" wire:navigate
               class="text-sm font-semibold text-zinc-900 hover:text-violet-700 transition-colors">
                {{ $other?->profile?->display_name ?? $other?->name ?? 'Member' }}
            </a>

            @if($other?->id_verified)
                <svg class="h-4 w-4 text-violet-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>

        {{-- Message list --}}
        <div class="flex-1 overflow-y-auto rounded-xl border border-zinc-200 bg-white p-4 space-y-3"
             x-data x-ref="messageList"
             x-init="$el.scrollTop = $el.scrollHeight"
             x-on:livewire:navigated.window="$nextTick(() => $el.scrollTop = $el.scrollHeight)">

            @if($messages->isEmpty())
                <div class="flex h-full flex-col items-center justify-center gap-2 text-center">
                    <svg class="h-8 w-8 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <p class="text-sm text-zinc-400">No messages yet. Say hello!</p>
                </div>
            @else
                @foreach($messages as $message)
                    @php $isMine = $message->sender_id === auth()->id(); @endphp
                    <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">
                            <div class="rounded-2xl px-4 py-2.5 text-sm leading-relaxed
                                        {{ $isMine
                                            ? 'rounded-br-sm bg-violet-600 text-white'
                                            : 'rounded-bl-sm bg-zinc-100 text-zinc-800' }}">
                                {{ $message->body }}
                            </div>
                            <p class="mt-1 text-xs text-zinc-400 {{ $isMine ? 'text-right' : '' }}">
                                {{ $message->created_at->format('g:i a') }}
                                @if(! $message->created_at->isToday())
                                    &middot; {{ $message->created_at->format('d M') }}
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Not-active notice --}}
        @if(! auth()->user()->isActive())
            <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                Your account verification is incomplete. Complete
                <a href="{{ route('onboarding.step', auth()->user()->onboarding_step) }}" wire:navigate
                   class="font-semibold underline">your setup</a> to send messages.
            </div>
        @else
            {{-- Compose --}}
            <div class="mt-3 flex gap-2">
                <input wire:model="newMessage"
                       wire:keydown.enter="sendMessage"
                       type="text"
                       placeholder="Type a message…"
                       maxlength="3000"
                       class="flex-1 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-900 placeholder-zinc-400 focus:border-violet-400 focus:outline-none focus:ring-2 focus:ring-violet-100" />
                <button wire:click="sendMessage"
                        wire:loading.attr="disabled"
                        class="flex items-center gap-1.5 rounded-xl bg-violet-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-violet-700 disabled:opacity-60 transition">
                    <span wire:loading.remove wire:target="sendMessage">Send</span>
                    <span wire:loading wire:target="sendMessage">…</span>
                    <svg class="h-4 w-4" wire:loading.remove wire:target="sendMessage" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
            @error('newMessage') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror

            <p class="mt-1.5 text-center text-xs text-zinc-400">
                Messages are monitored for spam. Do not share payment details on-platform.
            </p>
        @endif
    </div>
</x-layouts.app>
