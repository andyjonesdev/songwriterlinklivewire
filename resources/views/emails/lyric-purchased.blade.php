<h2>New Lyric Purchased 🎶</h2>

<p><strong>Lyric:</strong> {{ $purchase->lyric->title }}</p>
<p><strong>Buyer Email:</strong> {{ $purchase->user->email }}</p>
<p><strong>Amount:</strong> ${{ number_format($purchase->amount / 100, 2) }}</p>
<p><strong>Stripe Session ID:</strong> {{ $purchase->stripe_session_id }}</p>
