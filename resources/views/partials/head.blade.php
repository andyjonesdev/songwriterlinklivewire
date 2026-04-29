<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ isset($title) ? $title . ' — SongwriterLink' : 'SongwriterLink' }}</title>

{{-- Default meta --}}
<meta name="description" content="{{ $metaDescription ?? 'SongwriterLink — The verified professional network for songwriters, composers and producers.' }}" />
<meta property="og:site_name" content="SongwriterLink" />
<meta property="og:title" content="{{ isset($title) ? $title . ' — SongwriterLink' : 'SongwriterLink' }}" />
<meta property="og:description" content="{{ $metaDescription ?? 'SongwriterLink — The verified professional network for songwriters, composers and producers.' }}" />
<meta property="og:type" content="{{ $ogType ?? 'website' }}" />
<meta property="og:url" content="{{ url()->current() }}" />
@if(isset($metaImage))
    <meta property="og:image" content="{{ $metaImage }}" />
    <meta name="twitter:card" content="summary_large_image" />
@else
    <meta name="twitter:card" content="summary" />
@endif
<meta name="twitter:title" content="{{ isset($title) ? $title . ' — SongwriterLink' : 'SongwriterLink' }}" />
<meta name="twitter:description" content="{{ $metaDescription ?? 'SongwriterLink — The verified professional network for songwriters, composers and producers.' }}" />
<link rel="canonical" href="{{ url()->current() }}" />
@stack('meta')

<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'] },
                colors: {
                    brand: {
                        DEFAULT: '#7c3aed',
                        dark:    '#6d28d9',
                        light:   '#a78bfa',
                    },
                },
            },
        },
    }
</script>

@fluxAppearance
<style>
    /* ── Flux layout grid ─────────────────────────────────────────────────── */
    *:has(>[data-flux-main]) {
        display: grid;
        grid-area: body;
        grid-template-rows: auto 1fr auto;
        grid-template-columns: min-content minmax(0, 1fr) min-content;
        grid-template-areas:
            "header  header  header"
            "sidebar main    aside"
            "sidebar footer  aside";
    }
    *:has(>[data-flux-sidebar]+[data-flux-header]) {
        grid-template-areas:
            "sidebar header  header"
            "sidebar main    aside"
            "sidebar footer  aside";
    }
    /* ── Flux ui-button (needs block for sizing) ──────────────────────────── */
    ui-button { display: block; }
    /* ── Flux modals ──────────────────────────────────────────────────────── */
    [data-flux-modal]>dialog,[data-flux-modal]>dialog::backdrop{opacity:0;transition:all .075s allow-discrete}
    [data-flux-modal]>dialog{transform:scale(.95)}
    [data-flux-modal]>dialog[data-flux-flyout]{transform:scale(1) var(--flux-flyout-translate,translateX(50px))}
    [data-flux-modal]>dialog[open],[data-flux-modal]>dialog[open]::backdrop{opacity:1;transform:translateX(0) scale(1);transition:all .15s allow-discrete}
    @starting-style{[data-flux-modal]>dialog[open],[data-flux-modal]>dialog[open]::backdrop{opacity:0}[data-flux-modal]>dialog[open]{transform:scale(.95)}[data-flux-modal]>dialog[open][data-flux-flyout]{transform:scale(1) var(--flux-flyout-translate,translateX(50px))}}
    [data-flux-modal]>dialog::backdrop{background-color:rgba(0,0,0,.1)}
    /* ── Flux select (native chevron) ─────────────────────────────────────── */
    select[data-flux-select-native]{background-image:url("data:image/svg+xml,%3csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M8 9L12 5L16 9' stroke='%23d4d4d4' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3cpath d='M16 15L12 19L8 15' stroke='%23d4d4d4' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e");background-position:right .5rem center;background-repeat:no-repeat;background-size:1.5em 1.5em;padding-inline-end:2.5rem}
    select[data-flux-select-native]:hover:not(:disabled){background-image:url("data:image/svg+xml,%3csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M8 9L12 5L16 9' stroke='%2327272a' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3cpath d='M16 15L12 19L8 15' stroke='%2327272a' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e")}
    .dark select[data-flux-select-native]{background-image:url("data:image/svg+xml,%3csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M8 9L12 5L16 9' stroke='%23A1A1AA' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3cpath d='M16 15L12 19L8 15' stroke='%23A1A1AA' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3e%3c/svg%3e")}
    /* ── Flux scrollbar utility ───────────────────────────────────────────── */
    .flux-no-scrollbar{scrollbar-width:none;-ms-overflow-style:none}
    .flux-no-scrollbar::-webkit-scrollbar{display:none}
    /* ── Flux shimmer animation ───────────────────────────────────────────── */
    @keyframes flux-shimmer{0%{transform:translateX(0%)}100%{transform:translateX(200%)}}
</style>
