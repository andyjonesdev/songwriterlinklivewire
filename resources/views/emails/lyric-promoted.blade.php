<h2>New Lyric Promoted 🎶</h2>

<p><strong>Lyric:</strong> {{ $purchase->lyric_title }}</p>
<p><strong>Buyer Email:</strong> {{ $purchase->buyer_email }}</p>
<p><strong>Amount:</strong> ${{ number_format($purchase->amount / 100, 2) }}</p>
<p><strong>Stripe Payment ID:</strong> {{ $purchase->stripe_payment_id }}</p>
