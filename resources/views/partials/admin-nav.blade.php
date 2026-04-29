<div class="mb-6 flex flex-wrap gap-1 rounded-xl border border-zinc-200 bg-zinc-50 p-1">
    @php
        $links = [
            ['route' => 'admin.index',             'label' => 'Dashboard'],
            ['route' => 'admin.verification-queue','label' => 'ID Queue'],
            ['route' => 'admin.reports',           'label' => 'Reports'],
            ['route' => 'admin.producer-badges',   'label' => 'Badges'],
            ['route' => 'admin.suspended',         'label' => 'Suspended'],
            ['route' => 'admin.members',           'label' => 'Members'],
            ['route' => 'admin.promotions',        'label' => 'Promotions'],
        ];
    @endphp
    @foreach($links as $link)
        <a href="{{ route($link['route']) }}" wire:navigate
           class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors
                  {{ request()->routeIs($link['route']) ? 'bg-white text-zinc-900 shadow-sm' : 'text-zinc-500 hover:text-zinc-700' }}">
            {{ $link['label'] }}
        </a>
    @endforeach
</div>
