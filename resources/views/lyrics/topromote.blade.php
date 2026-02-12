<x-layouts.app :title="__('To Promote Lyric')">
    @foreach ($lyrics as $lyric)
        <div class="bg-gray-200 p-4 mb-2">
            <!-- {{ $lyric }} -->
            <h2>Title: {{ $lyric->title }}</h2>
            <h3>Genre: {{ $lyric->genre }}</h3>
            <h3>By: {{ $lyric->user->name ?? 'Unknown' }}</h3>

            <pre class="whitespace-pre-wrap mt-2 bg-gray-50 p-4">{{ \Illuminate\Support\Str::limit($lyric->content, 400) }}</pre>
            
            <label class="inline-flex items-center gap-2 mt-2">
                <input type="checkbox"
                    {{ $lyric->used ? 'checked' : '' }}
                    onchange="markUsed(this, {{ $lyric->id }})">
                <span>Mark as used</span>
            </label>

            <script>
                function markUsed(checkbox, lyricId) {
                    console.log('Mark used');
                    fetch(`/lyrics/${lyricId}/used`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            social_used: checkbox.checked ? 1 : 0
                        })
                    })
                    .catch(() => {
                        alert('Something went wrong');
                        checkbox.checked = !checkbox.checked; // revert UI
                    });
                }
            </script>
        </div>
    @endforeach
    <div class="mt-8">
        {{ $lyrics->links() }}
    </div>
</x-layouts.app>
