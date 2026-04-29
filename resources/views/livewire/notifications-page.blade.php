<div class="mx-auto max-w-2xl space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Notifications</h1>
            <p class="mt-0.5 text-sm text-zinc-500">
                {{ auth()->user()->unreadNotifications->count() }} unread
            </p>
        </div>
        @if(auth()->user()->unreadNotifications->count())
            <button wire:click="markAllRead"
                    class="rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-600 hover:border-zinc-300 transition">
                Mark all read
            </button>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="flex flex-col items-center gap-3 rounded-xl border border-zinc-100 bg-zinc-50 py-16 text-center">
            <svg class="h-10 w-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <p class="text-sm font-medium text-zinc-500">No notifications yet.</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($notifications as $notification)
                @php $data = $notification->data; @endphp
                <div class="flex items-start gap-3 rounded-xl border p-4 transition
                            {{ $notification->read_at ? 'border-zinc-100 bg-white' : 'border-violet-200 bg-violet-50' }}">

                    {{-- Icon based on type --}}
                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                {{ $notification->read_at ? 'bg-zinc-100' : 'bg-violet-100' }}">
                        @if(($data['type'] ?? '') === 'brief_application')
                            <svg class="h-4 w-4 {{ $notification->read_at ? 'text-zinc-400' : 'text-violet-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        @elseif(($data['type'] ?? '') === 'connection_request' || ($data['type'] ?? '') === 'connection_accepted')
                            <svg class="h-4 w-4 {{ $notification->read_at ? 'text-zinc-400' : 'text-violet-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        @elseif(($data['type'] ?? '') === 'brief_shortlisted')
                            <svg class="h-4 w-4 {{ $notification->read_at ? 'text-zinc-400' : 'text-violet-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="h-4 w-4 {{ $notification->read_at ? 'text-zinc-400' : 'text-violet-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm {{ $notification->read_at ? 'text-zinc-600' : 'font-medium text-zinc-900' }}">
                            {{ $data['message'] ?? '' }}
                        </p>
                        <p class="mt-0.5 text-xs text-zinc-400">{{ $notification->created_at->diffForHumans() }}</p>
                        @if(!empty($data['url']))
                            <a href="{{ $data['url'] }}" wire:navigate
                               class="mt-1 inline-block text-xs text-violet-600 hover:underline">
                                View →
                            </a>
                        @endif
                    </div>

                    <div class="flex shrink-0 items-center gap-1">
                        @if(!$notification->read_at)
                            <button wire:click="markRead('{{ $notification->id }}')"
                                    class="rounded p-1 text-zinc-400 hover:text-zinc-600 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        @endif
                        <button wire:click="delete('{{ $notification->id }}')"
                                class="rounded p-1 text-zinc-300 hover:text-red-400 transition">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        <div>{{ $notifications->links() }}</div>
    @endif
</div>
