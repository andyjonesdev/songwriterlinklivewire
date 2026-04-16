<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SongwriterLink membership renewal</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f4f4f5; margin: 0; padding: 32px 16px; color: #18181b; }
        .card { background: #fff; border-radius: 12px; max-width: 520px; margin: 0 auto; padding: 40px 36px; }
        .logo { font-size: 18px; font-weight: 700; color: #7c3aed; margin-bottom: 32px; }
        h1 { font-size: 22px; font-weight: 700; margin: 0 0 12px; }
        p { font-size: 15px; line-height: 1.6; color: #52525b; margin: 0 0 16px; }
        .badge { display: inline-block; background: #f4f3ff; color: #7c3aed; border-radius: 6px; padding: 6px 14px; font-size: 14px; font-weight: 600; margin-bottom: 24px; }
        .btn { display: inline-block; background: #7c3aed; color: #fff; text-decoration: none; border-radius: 8px; padding: 13px 28px; font-size: 15px; font-weight: 600; margin: 8px 0 24px; }
        .footer { margin-top: 32px; font-size: 12px; color: #a1a1aa; text-align: center; }
        .footer a { color: #a1a1aa; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">SongwriterLink</div>

        <h1>Your membership expires
            @if($daysRemaining === 3) in 3 days
            @else in 2 weeks
            @endif
        </h1>

        <div class="badge">
            {{ ucfirst(str_replace('_', ' ', $user->subscription_tier)) }} membership
            &middot;
            expires {{ $user->subscription_expires_at->format('j F Y') }}
        </div>

        <p>Hi {{ $user->name }},</p>

        <p>
            Your SongwriterLink
            <strong>{{ $user->subscription_tier === 'pro_plus' ? 'Pro+' : 'Pro' }}</strong>
            membership expires on <strong>{{ $user->subscription_expires_at->format('j F Y') }}</strong>.
            @if($daysRemaining === 3)
                That's just 3 days away.
            @else
                Renewing now locks in your current plan and keeps your profile, portfolio, and analytics uninterrupted.
            @endif
        </p>

        <p>When your membership expires your account automatically moves to the Free tier — your profile and messages stay intact, but Pro features (analytics, search boost, unlimited portfolio, and more) will be paused.</p>

        <a href="{{ url('/settings') }}" class="btn">Renew my membership</a>

        <p style="font-size:13px; color:#71717a;">
            You're receiving this because your SongwriterLink membership is due for renewal.
            If you have any questions, reply to this email and we'll help.
        </p>

        <div class="footer">
            &copy; {{ date('Y') }} SongwriterLink &middot;
            <a href="{{ url('/privacy') }}">Privacy</a> &middot;
            <a href="{{ url('/settings') }}">Manage account</a>
        </div>
    </div>
</body>
</html>
