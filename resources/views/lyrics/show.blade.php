
<x-layouts.page :title="__($lyric->title. ' - Songwriter Link Original Song Lyrics')" :description="__('Song Lyrics by ' . $lyric->user->name)">
    <script type="application/ld+json">
<?php
echo json_encode([
    "@context" => "https://schema.org",
    "@type" => "Product",
    "name" => $lyric->title,
    "description" => "Original ".$lyric->genre." song lyrics written by ".$lyric->user->name.". Licensed for recording and commercial release.",
    "url" => url()->current(),
    "category" => "Digital lyrics",
    "brand" => [
        "@type" => "Person",
        "name" => $lyric->user->name
    ],
    "additionalProperty" => [
        [
            "@type" => "PropertyValue",
            "name" => "Genre",
            "value" => $lyric->genre
        ],
        [
            "@type" => "PropertyValue",
            "name" => "License Type",
            "value" => $lyric->license_type ?? "Standard lyric license"
        ]
    ],
    "offers" => [
        "@type" => "Offer",
        "url" => url()->current(),
        "priceCurrency" => "USD",
        "price" => $lyric->price,
        "availability" => "https://schema.org/InStock"
    ]
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
</script>

<script type="application/ld+json">
<?php
echo json_encode([
  "@context" => "https://schema.org",
  "@type" => "BreadcrumbList",
  "itemListElement" => [
    [
      "@type" => "ListItem",
      "position" => 1,
      "name" => "Home",
      "item" => url('/')
    ],
    [
      "@type" => "ListItem",
      "position" => 2,
      "name" => "Buy Lyrics",
      "item" => url('/buy-lyrics')
    ],
    [
      "@type" => "ListItem",
      "position" => 3,
      "name" => $lyric->genre." Lyrics",
      "item" => url('/buy-'.strtolower($lyric->genre).'-lyrics')
    ],
    [
      "@type" => "ListItem",
      "position" => 4,
      "name" => $lyric->title,
      "item" => url()->current()
    ]
  ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
</script>

    <div class="flex flex-col px-6 text-[#1b1b18] lg:justify-between lg:px-8">
        <nav class="text-sm text-gray-600 mb-4">
            <a href="/">Home</a> ›
            <a href="/buy-lyrics">Buy Lyrics</a> ›
            <a href="/buy-{{ strtolower($lyric->genre) }}-lyrics">
                {{ $lyric->genre }} Lyrics
            </a> ›
            <span>{{ $lyric->title }}</span>
        </nav>
    
        <div class="flex w-full opacity-100 transition-opacity duration-750 lg:grow">
        <main class="flex lg:w-2/3 flex-col overflow-hidden rounded-lg">

            <div class="flex-1 rounded-lg p-4 pb-12 text-[13px] leading-[20px]
                bg-[#ffffff78] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)]
                lg:p-20">

                <h1 class="mb-4 font-medium text-6xl">
                    {{ $lyric->title }}
                </h1>

                <h2 class="text-lg">
                    Written By:
                    <b>
                        <a
                            href="{{ route('users.show', $lyric->user) }}"
                            class="font-semibold hover:underline"
                        >
                            {{ $lyric['user']['name'] }}</a></b>
                </h2>

                <h3 class="text-lg">
                    Genre:
                    <b>{{ $lyric->genre }}</b>
                </h3>

                <pre class="whitespace-pre-wrap my-6 bg-gray-50 p-4">{{ $lyric->content }}</pre>

                <h4 class="text-lg font-semibold mt-6">
                    Standard License Terms
                </h4>

                <p class="my-2 text-lg">
                    The following rights are granted:
                </p>

                <ul class="list-disc ml-8 text-lg">
                    <li>Public performance rights</li>
                    <li>Synchronization rights for video/visual content</li>
                    <li>Internet broadcasting rights</li>
                    <li>Reproduction rights for CD, DVD, and digital downloads</li>
                    <li>Radio and television broadcast rights</li>
                    <li>Film, games, and musical theatre usage</li>
                </ul>

                <h3 class="text-2xl my-6">
                    Price: <b>${{ $lyric->price }}</b>
                </h3>

                <p class="my-8 p-2 bg-yellow-100 dark:bg-gray-900 text-lg">
                    <b>Important!</b>
                    This lyric is not available for use unless you purchase the licence.
                </p>

                {{-- Buy button --}}
                @guest
                    <p class="text-lg my-4">To buy a licence for this lyric, please register or login first.</p>
                    <div class="flex gap-2">
                        <a
                            href="/register?role=buyer"
                            class="rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg
                                leading-normal text-white">
                            Register
                        </a>
                        <a
                            href="/login"
                            class="rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg
                                leading-normal text-white">
                            Log in
                        </a>
                    </div>
                @else
                    @if ($lyric->price==20)
                    <a
                        href="https://buy.stripe.com/cNicMY5Rk5DA4Uz9Uybo403?prefilled_email={{ auth()->user()->email }}&client_reference_id=lyric-{{ auth()->id() }}-{{ $lyric->id }}"
                        class="rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white"
                    >
                        Buy Now
                    </a>
                    @endif
                    @if ($lyric->price==40)
                    <a
                        href="https://buy.stripe.com/7sYcMYbbE2rodr5giWbo404?prefilled_email={{ auth()->user()->email }}&client_reference_id=lyric-{{ auth()->id() }}-{{ $lyric->id }}"
                        class="rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white"
                    >
                        Buy Now
                    </a>
                    @endif
                    @if ($lyric->price==60)
                    <a
                        href="https://buy.stripe.com/fZudR20x00jg72Hc2Gbo405?prefilled_email={{ auth()->user()->email }}&client_reference_id=lyric-{{ auth()->id() }}-{{ $lyric->id }}"
                        class="rounded-sm bg-[#e8363c] px-5 py-2 my-4 text-lg leading-normal text-white"
                    >
                        Buy Now
                    </a>
                    @endif
                <a href="https://buy.stripe.com/9B6cMYfrU2ro5YDeaObo402?prefilled_email={{ auth()->user()->email }}&client_reference_id=lyric-{{ auth()->id() }}-{{ $lyric->id }}"
                class="hidden">Buy Test</a>
                @endguest

            </div>
        </main>
    </div>
        
    </div>

</x-layouts.page>
