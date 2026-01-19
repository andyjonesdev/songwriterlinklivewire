<h2>New Lyric Promoted 🎶</h2>

<p><strong>Lyric:</strong> {{ $purchase->lyric->title }}</p>
<p><strong>Buyer Email:</strong> {{ $purchase->user->email }}</p>
<p><strong>Amount:</strong> ${{ $purchase->amount }}</p>
<p><strong>Stripe Payment ID:</strong> {{ $purchase->stripe_session_id }}</p>
