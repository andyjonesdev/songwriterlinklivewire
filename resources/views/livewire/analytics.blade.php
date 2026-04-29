<div class="mx-auto max-w-4xl space-y-6">

    {{-- Chart.js (loaded once per page) --}}
    @once
        @push('meta')
            <script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js" defer></script>
        @endpush
    @endonce

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Analytics</h1>
            <p class="mt-0.5 text-sm text-zinc-500">How your profile is performing.</p>
        </div>

        {{-- Period selector --}}
        <div class="flex rounded-lg border border-zinc-200 bg-white text-sm dark:border-zinc-700 dark:bg-zinc-900">
            @foreach(['7' => '7d', '30' => '30d', '90' => '90d'] as $val => $label)
                <button wire:click="$set('period', '{{ $val }}')"
                        class="px-3 py-1.5 font-medium transition
                            {{ $period === $val
                                ? 'bg-violet-600 text-white rounded-lg'
                                : 'text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Top stats row --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Profile views this period --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-400">Views ({{ $period }}d)</p>
            <p class="mt-1 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($viewsThisPeriod) }}</p>
            <div class="mt-1 flex items-center gap-1">
                @if($viewsTrend !== null)
                    @if($viewsTrend > 0)
                        <svg class="h-3 w-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/></svg>
                        <span class="text-xs font-semibold text-green-600">+{{ $viewsTrend }}%</span>
                    @elseif($viewsTrend < 0)
                        <svg class="h-3 w-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        <span class="text-xs font-semibold text-red-500">{{ $viewsTrend }}%</span>
                    @else
                        <span class="text-xs text-zinc-400">No change</span>
                    @endif
                    <span class="text-xs text-zinc-400">vs prev period</span>
                @else
                    <span class="text-xs text-zinc-400">{{ number_format($viewsLifetime) }} lifetime</span>
                @endif
            </div>
        </div>

        {{-- Connections --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-400">Connections</p>
            <p class="mt-1 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($connectionsTotal) }}</p>
            <div class="mt-1 flex items-center gap-2">
                @if($connectionsThisPeriod > 0)
                    <span class="text-xs font-semibold text-green-600">+{{ $connectionsThisPeriod }} this period</span>
                @endif
                @if($connectionsPending > 0)
                    <span class="text-xs text-violet-600">{{ $connectionsPending }} pending</span>
                @endif
                @if($connectionsThisPeriod === 0 && $connectionsPending === 0)
                    <span class="text-xs text-zinc-400">No new this period</span>
                @endif
            </div>
        </div>

        {{-- Brief applications --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-400">Applications</p>
            <p class="mt-1 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($appTotal) }}</p>
            <div class="mt-1 flex items-center gap-2">
                @if($shortlistRate !== null)
                    <span class="text-xs font-semibold text-violet-600">{{ $shortlistRate }}% shortlisted</span>
                @else
                    <span class="text-xs text-zinc-400">No applications yet</span>
                @endif
            </div>
        </div>

        {{-- Profile completeness --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-semibold uppercase tracking-wide text-zinc-400">Profile Score</p>
            <p class="mt-1 text-3xl font-bold
                {{ $completenessScore === 100 ? 'text-green-600' : ($completenessScore >= 70 ? 'text-violet-600' : 'text-amber-500') }}">
                {{ $completenessScore }}%
            </p>
            <div class="mt-2 h-1.5 w-full rounded-full bg-zinc-100 dark:bg-zinc-700">
                <div class="h-1.5 rounded-full transition-all
                    {{ $completenessScore === 100 ? 'bg-green-500' : ($completenessScore >= 70 ? 'bg-violet-500' : 'bg-amber-400') }}"
                     style="width: {{ $completenessScore }}%"></div>
            </div>
        </div>
    </div>

    {{-- Views chart --}}
    <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
        <h2 class="mb-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Profile Views — Last {{ $period }} Days</h2>
        <div class="relative h-48">
            <canvas id="viewsChart" wire:ignore></canvas>
        </div>
    </div>

    {{-- Two column lower row --}}
    <div class="grid gap-4 lg:grid-cols-2">

        {{-- Brief application breakdown --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Brief Applications</h2>
            @if($appTotal === 0)
                <p class="text-sm text-zinc-400">No applications submitted yet.</p>
            @else
                <div class="space-y-3">
                    @foreach([
                        ['label' => 'Pending',     'count' => $appPending,     'color' => 'bg-zinc-200'],
                        ['label' => 'Shortlisted', 'count' => $appShortlisted, 'color' => 'bg-violet-500'],
                        ['label' => 'Declined',    'count' => $appDeclined,    'color' => 'bg-red-300'],
                    ] as $row)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs">
                                <span class="font-medium text-zinc-600 dark:text-zinc-300">{{ $row['label'] }}</span>
                                <span class="text-zinc-500">{{ $row['count'] }} / {{ $appTotal }}</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-zinc-100 dark:bg-zinc-700">
                                <div class="h-2 rounded-full {{ $row['color'] }}"
                                     style="width: {{ $appTotal > 0 ? round(($row['count'] / $appTotal) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($shortlistRate !== null)
                    <p class="mt-4 text-xs text-zinc-400">
                        Your shortlist rate is <span class="font-semibold text-violet-600">{{ $shortlistRate }}%</span>.
                        @if($shortlistRate >= 50)
                            Great going — publishers are noticing you.
                        @elseif($shortlistRate >= 20)
                            Solid start. Keep refining your pitches.
                        @else
                            Try tailoring each application more closely to the brief.
                        @endif
                    </p>
                @endif
            @endif
        </div>

        {{-- Profile completeness checklist --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-4 text-sm font-semibold text-zinc-700 dark:text-zinc-200">Profile Completeness</h2>
            <ul class="space-y-2">
                @foreach($completenessChecks as $label => $done)
                    <li class="flex items-center gap-2.5">
                        @if($done)
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-green-100">
                                <svg class="h-3 w-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-sm text-zinc-600 dark:text-zinc-300">{{ $label }}</span>
                        @else
                            <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-zinc-100 dark:bg-zinc-700">
                                <svg class="h-3 w-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </span>
                            <span class="text-sm text-zinc-400">{{ $label }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
            @if($completenessScore < 100)
                <a href="{{ route('settings.profile') }}" wire:navigate
                   class="mt-4 inline-block text-xs font-medium text-violet-600 hover:underline">
                    Complete your profile →
                </a>
            @endif
        </div>
    </div>

</div>

{{-- Chart.js initialisation — reinitialises when period changes via Livewire --}}
<script>
    (function () {
        const labels  = {!! $viewLabels !!};
        const data    = {!! $viewSeries !!};
        const isDark  = document.documentElement.classList.contains('dark');

        function initChart() {
            const canvas = document.getElementById('viewsChart');
            if (!canvas) return;

            // Destroy existing chart instance if present (Livewire re-render)
            if (canvas._chartInstance) {
                canvas._chartInstance.destroy();
            }

            const ctx = canvas.getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.offsetHeight || 192);
            gradient.addColorStop(0, 'rgba(124, 58, 237, 0.25)');
            gradient.addColorStop(1, 'rgba(124, 58, 237, 0)');

            canvas._chartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        data,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#7c3aed',
                        borderWidth: 2,
                        pointBackgroundColor: '#7c3aed',
                        pointRadius: data.length <= 14 ? 3 : 0,
                        pointHoverRadius: 5,
                        tension: 0.4,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                title: (items) => items[0].label,
                                label: (item) => ` ${item.raw} view${item.raw !== 1 ? 's' : ''}`,
                            },
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: isDark ? '#71717a' : '#a1a1aa',
                                font: { size: 10 },
                                maxTicksLimit: 8,
                                maxRotation: 0,
                            },
                            border: { display: false },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: isDark ? '#71717a' : '#a1a1aa',
                                font: { size: 10 },
                                precision: 0,
                                maxTicksLimit: 5,
                            },
                            grid: { color: isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.04)' },
                            border: { display: false },
                        },
                    },
                },
            });
        }

        // Run after Chart.js is ready (it's loaded with defer)
        if (typeof Chart !== 'undefined') {
            initChart();
        } else {
            document.querySelector('script[src*="chart.js"]')
                ?.addEventListener('load', initChart);
        }

        // Re-init on Livewire morphing (period change)
        document.addEventListener('livewire:navigated', initChart);
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => { setTimeout(initChart, 50); });
        });
    })();
</script>
