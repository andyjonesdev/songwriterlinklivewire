<div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-6">

        <h1 class="text-2xl font-bold mb-6">Promoted Lyrics Stats</h1>

        {{-- Summary cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-4 text-center">
                <div class="text-3xl font-bold">{{ $totalCount }}</div>
                <div class="text-sm text-gray-500 mt-1">Total</div>
            </div>
            <div class="rounded-lg border border-green-400 p-4 text-center">
                <div class="text-3xl font-bold text-green-600">{{ $activeCount }}</div>
                <div class="text-sm text-gray-500 mt-1">Active</div>
            </div>
            <div class="rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-4 text-center">
                <div class="text-3xl font-bold text-gray-400">{{ $expiredCount }}</div>
                <div class="text-sm text-gray-500 mt-1">Expired</div>
            </div>
            <div class="rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-4 text-center">
                <div class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Revenue</div>
            </div>
            <div class="rounded-lg border border-sidebar-border/70 dark:border-sidebar-border p-4 text-center">
                <div class="text-3xl font-bold">{{ $manualCount }}</div>
                <div class="text-sm text-gray-500 mt-1">Manual</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-sidebar-border/70 dark:border-sidebar-border text-left text-gray-500">
                        <th class="pb-2 pr-4">Lyric</th>
                        <th class="pb-2 pr-4">User</th>
                        <th class="pb-2 pr-4">Placement</th>
                        <th class="pb-2 pr-4">Duration</th>
                        <th class="pb-2 pr-4">Bid</th>
                        <th class="pb-2 pr-4">Amount</th>
                        <th class="pb-2 pr-4">Starts</th>
                        <th class="pb-2 pr-4">Ends</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotions as $promo)
                        @php $active = $promo->ends_at >= now(); @endphp
                        <tr class="border-b border-sidebar-border/70 dark:border-sidebar-border {{ $active ? '' : 'opacity-50' }}">
                            <td class="py-2 pr-4">
                                {{ $promo->lyric->title ?? '—' }}
                                @if (str_starts_with($promo->stripe_session_id, 'manual_'))
                                    <span class="ml-1 text-xs text-gray-400">(manual)</span>
                                @endif
                            </td>
                            <td class="py-2 pr-4">{{ $promo->user->name ?? '—' }}</td>
                            <td class="py-2 pr-4">{{ $promo->placement }}</td>
                            <td class="py-2 pr-4">
                                @if ($promo->duration == 1) 1 week
                                @elseif ($promo->duration == 2) 2 weeks
                                @else 1 month
                                @endif
                            </td>
                            <td class="py-2 pr-4">${{ $promo->bid }}</td>
                            <td class="py-2 pr-4">${{ $promo->amount }}</td>
                            <td class="py-2 pr-4">{{ $promo->starts_at->format('d M Y') }}</td>
                            <td class="py-2 pr-4">{{ $promo->ends_at->format('d M Y') }}</td>
                            <td class="py-2">
                                @if ($active)
                                    <span class="text-green-600 font-semibold">Active</span>
                                @else
                                    <span class="text-gray-400">Expired</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $promotions->links() }}
        </div>
    </div>
</div>
