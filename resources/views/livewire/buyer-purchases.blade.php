

    <div class="">
        <h1 class="text-2xl font-bold mb-4">Your Purchased Lyrics</h1>

        @forelse ($purchases as $purchase)
            <div class="mb-8 lg:grid gap-6 rounded-xl border p-6 grid-cols-3">

                
                <div class="space-y-3">
                    <h2 class="text-xl font-bold">
                        {{ $purchase->lyric->title }}
                    </h2>

                    <p class="text-sm text-gray-600">
                        Written by {{ $purchase->lyric->writer->name }}
                    </p>

                    <p class="">
                        <strong>Price:</strong>
                        ${{ number_format($purchase->lyric->price, 2) }}
                    </p>

                    <p class="">
                        <strong>Purchased on:</strong>
                        {{ $purchase->created_at->format('M d, Y') }}
                    </p>

                    <!-- <p>
                        <strong>Type:</strong>
                        {{ $purchase->license_type ?? 'Standard' }}
                    </p> -->

                    <h4 class="font-semibold text-sm">
                        Standard License Terms
                    </h4>

                    <p class="my-2 text-sm">
                        The following rights are granted:
                    </p>

                    <ul class="list-disc ml-8 text-sm mb-4">
                        <li>Public performance rights</li>
                        <li>Synchronization rights for video/visual content</li>
                        <li>Internet broadcasting rights</li>
                        <li>Reproduction rights for CD, DVD, and digital downloads</li>
                        <li>Radio and television broadcast rights</li>
                        <li>Film, games, and musical theatre usage</li>
                    </ul>

                    @if ($purchase->license_terms)
                        <p class="mt-2 text-xs text-gray-600 whitespace-pre-line">
                            {{ $purchase->license_terms }}   
                        </p>
                    @endif
                </div>

                <div class="rounded-lg bg-gray-100 p-4 w-full col-span-2">
                    <pre class="whitespace-pre-wrap text-sm font-mono">{{ $purchase->lyric->content }}</pre>
                </div>

            </div>
        @empty
            <p>You haven't bought anything yet.</p>
        @endforelse


    </div>
