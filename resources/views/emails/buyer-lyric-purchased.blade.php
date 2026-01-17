<h2>Thank you for your purchase 🎶</h2>

<p>
    Hi{{ $purchase->buyer_name ? ' ' . $purchase->buyer_name : '' }},
</p>

<p>
    Thanks for purchasing a lyric on <strong>SongwriterLink</strong>.
</p>

<hr>

<p><strong>Lyric:</strong> {{ $purchase->lyric_title }}</p>
<p><strong>Amount Paid:</strong> ${{ number_format($purchase->amount / 100, 2) }}</p>
<p><strong>Order ID:</strong> {{ $purchase->id }}</p>

@if($purchase->download_url)
<p>
    <a href="{{ $purchase->download_url }}">
        Download your lyric
    </a>
</p>
@endif

<hr>

<p>
    If you have any questions, reply to this email and we’ll help you out.
</p>

<p>
    — SongwriterLink
</p>
