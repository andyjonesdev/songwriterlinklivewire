<h2>Thank you for your purchase 🎶</h2>

<p>Hi {{ $purchase->user->name}},</p>

<p>Thanks for purchasing a lyric on <strong>SongwriterLink</strong>.</p>

<p><strong>Lyric:</strong> {{ $purchase->lyric->title }}</p>
<p><strong>Amount Paid:</strong> ${{ number_format($purchase->amount / 100, 2) }}</p>
<!-- <p><strong>Order ID:</strong> {{ $purchase->id }}</p> -->

@if($purchase->download_url)
<p>
    <a href="{{ $purchase->download_url }}">
        Download your lyric
    </a>
</p>
@endif

<p>If you have any questions, reply to this email and we’ll help you out.</p>

<p>SongwriterLink</p>
