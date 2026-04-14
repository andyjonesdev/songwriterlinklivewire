# Songwriterlink — Claude Code Build Prompt

## Project overview

Build **songwriterlink.com** as a verified songwriter networking platform. This replaces a failed lyrics marketplace. The core proposition is: every member is ID verified, messaging is free for all members, and monetisation comes from visibility, credibility tools, and industry features — not from access to people.

This is a greenfield Laravel application. Use the stack and conventions below throughout.

---

## Tech stack

- **Backend:** Laravel 11 (PHP 8.3)
- **Frontend:** Livewire 3 + Alpine.js (no Inertia, no Vue — hosting environment does not support Node/Vite build pipeline)
- **Styling:** Tailwind CSS (CDN or pre-compiled; no npm build step required)
- **Database:** MySQL 8
- **File storage:** Laravel Filesystem with `local` driver using the hosting provider's disk — no S3 or external object storage
- **Payments & ID verification:** Stripe (Stripe Identity for ID checks, Stripe Billing for subscriptions)
- **SMS:** Twilio (phone verification)
- **Search:** Laravel Scout + Meilisearch
- **Email:** Laravel Mail with Postmark driver (`symfony/postmark-mailer`)
- **Queue:** Laravel Queues with database driver (no Redis — use `php artisan queue:work` via cron or hosting scheduler)
- **AI content detection:** Anthropic Claude API (bio and content scanning)
- **Auth:** Laravel Breeze (Blade + Livewire stack) as starting point, then customised

---

## Database models & relationships

### User
```
id, name, email, email_verified_at, password,
phone, phone_verified_at,
role (enum: songwriter, composer, producer, publisher, other),
stripe_customer_id, stripe_subscription_id, subscription_tier (enum: free, pro, pro_plus),
id_verified (bool), id_verified_at, id_verification_status (enum: pending, passed, failed, review),
producer_verified (bool), publisher_verified (bool),
joining_fee_paid (bool), joining_fee_paid_at,
status (enum: pending, active, suspended, banned),
suspension_reason,
report_count,
created_at, updated_at
```

### Profile
```
id, user_id,
display_name, slug, bio, location, country,
profile_photo_path, profile_photo_flagged (bool),
genres (JSON array),
social_links (JSON: spotify, soundcloud, imdb, linkedin, prs_ascap, discogs),
is_searchable (bool), search_boost_weight (int, default 1, Pro = 2, Pro+ = 3),
views_count, connections_count,
created_at, updated_at
```

### PortfolioItem
```
id, user_id,
type (enum: audio, lyrics),
title, description,
file_path, file_size, duration_seconds,
is_public (bool),
ai_flagged (bool),
created_at, updated_at
```
Free members: max 3 items. Pro/Pro+: unlimited.

### Connection
```
id, requester_id, recipient_id,
status (enum: pending, accepted, declined),
created_at, updated_at
```

### Message
```
id, conversation_id, sender_id,
body,
flagged (bool), flagged_reason,
read_at,
created_at
```

### Conversation
```
id, created_at, updated_at
```

### ConversationParticipant
```
id, conversation_id, user_id, last_read_at
```

### Brief
```
id, user_id (poster),
title, description,
category (enum: co_writer, topline, sync_placement, ghost_write, session_lyricist),
genres (JSON array),
compensation_type (enum: split, fee, spec),
compensation_detail,
deadline,
status (enum: open, closed, expired),
expires_at,
created_at, updated_at
```
Posting requires Pro+ or a one-off posting fee (£5–10 via Stripe).

### BriefApplication
```
id, brief_id, applicant_id,
pitch_text,
portfolio_item_id (nullable),
status (enum: pending, shortlisted, rejected),
created_at, updated_at
```

### VerificationLog
```
id, user_id,
event (enum: id_check_started, id_check_passed, id_check_failed, phone_verified, 
             producer_badge_granted, publisher_badge_granted, account_suspended, 
             account_reinstated, report_received),
detail (JSON),
created_at
```

### Report
```
id, reporter_id, reported_user_id,
reason (enum: fake_producer, payment_scam, harassment, spam, other),
detail,
status (enum: open, reviewed, actioned, dismissed),
created_at, updated_at
```

### PromotedProfile
```
id, user_id,
starts_at, ends_at,
stripe_payment_intent_id,
active (bool),
created_at
```

---

## Onboarding & verification flow

Implement as a multi-step flow using a single Livewire component (`OnboardingWizard`) that manages state across steps. Progress is stored on the User model (use a `onboarding_step` column: integer 1–10). Each step renders a different Blade partial within the component.

### Step 1 — Role selection
- Page: `/join`
- User selects their role (songwriter, composer, producer, publisher, other)
- Producers and publishers are flagged internally for higher verification requirements
- Store role on User, redirect to step 2

### Step 2 — Email & password
- Standard registration form
- On submit: create User record (status = pending), send email verification link
- Do not advance until email is verified

### Step 3 — Phone verification
- Show phone number input
- On submit: send SMS via Twilio with 6-digit code
- On code entry: verify code, check phone number is not already used by another active account (if duplicate: block silently, flag for review — do NOT tell the user why)
- Store `phone_verified_at`

### Step 4 — Joining fee
- Show Stripe payment element for £4 one-time fee
- If user has already selected Pro or Pro+ on a previous screen, skip this step (waive fee)
- On payment success: set `joining_fee_paid = true`

### Step 5 — ID verification (Stripe Identity)
- Trigger a Stripe Identity verification session
- Show Stripe Identity embedded UI
- On webhook `identity.verification_session.verified`: set `id_verified = true`, `id_verification_status = passed`
- On webhook `identity.verification_session.requires_input` (second failure): set status to `review`, notify admin
- Do not store any raw document data — Stripe handles this

### Step 6 — Profile setup
- Display name, location, genres (multi-select), bio
- At least one social link required (Spotify, SoundCloud, IMDB, LinkedIn, PRS/ASCAP, Discogs)
- On bio submission: call Claude API to scan for AI-generated content (see AI scanning section)
- If AI-flagged: show warning, ask user to rewrite — do not hard-block but log flag

### Step 7 — Profile photo
- Upload profile photo
- Run basic stock photo / AI face detection (see below)
- If flagged: note for admin review, do not block

### Step 8 — Portfolio upload (optional)
- Up to 3 audio tracks or lyric text files
- Show: "Add a track now and be discoverable from day one"
- Skip button available

### Step 9 — Plan selection
- Show Free / Pro / Pro+ options with feature comparison
- For each paid tier, show three term options: Annual (£80 / £180) — presented as default and best value, 6 months (£45 / £100), 3 months (£25 / £55)
- Annual option is visually prominent with a "Best value" label
- If user paid the joining fee in step 4, Pro annual is highlighted as recommended
- Stripe Checkout (one-time payment) for chosen tier + term — on success, set `subscription_tier`, `subscription_expires_at`, `subscription_term`

### Step 10 — Complete
- Set `status = active`
- Redirect to dashboard
- Show welcome screen with suggested connections based on role and genres

---

## Higher verification — producers & publishers

These run after the standard flow completes, triggered when role = producer or publisher.

### Producer verification
- Prompt: "To display a verified producer badge, please provide at least one verifiable credit"
- Accept: Discogs artist URL, AllMusic URL, or a DSP release link (Spotify/Apple Music)
- Auto-check: attempt to scrape/verify the link exists and matches their name
- If verified: set `producer_verified = true`, award badge
- If unverifiable: create a support ticket for manual review, display "Verification pending" state
- Companies House lookup (optional): if they provide a company name, verify against Companies House API

### Publisher / label verification
- Require: company registration number
- Auto-verify against Companies House API
- Require: domain email (reject Gmail, Hotmail, Yahoo, etc.)
- If verified: set `publisher_verified = true`, award badge
- Edge cases go to manual review queue (admin panel), resolved within 48 hours

---

## Membership & subscriptions

No monthly billing. All plans are prepaid fixed-term to maximise upfront revenue and minimise failed repeat payment churn (a known problem on verse-chorus with monthly billing).

### Pricing

| Plan | Annual | 6 months | 3 months |
|------|--------|----------|----------|
| Pro | £80 | £45 | £25 |
| Pro+ | £180 | £100 | £55 |

Present **annual as the default and most prominent option** on the plan selection screen. 6-month and 3-month are secondary options. Never show a monthly price equivalent — present only the lump sum.

### Stripe implementation
Use Stripe one-time Checkout Sessions (not recurring subscriptions) for each term length. This avoids the failed recurring payment problem entirely — each payment is a single charge, and the subscription simply expires at the end of the term.

On the User model, store:
- `subscription_tier` (enum: free, pro, pro_plus)
- `subscription_expires_at` (datetime)
- `subscription_term` (enum: annual, six_month, three_month)

A scheduled daily job (`CheckExpiredSubscriptions`) downgrades any user whose `subscription_expires_at` has passed to `free` tier, and sends a renewal reminder email at 14 days and 3 days before expiry.

### Feature gating
Create a `MembershipService` or use a policy/gate approach:

```php
// Example gates
Gate::define('upload-unlimited-portfolio', fn($user) => $user->isPro());
Gate::define('post-brief-free', fn($user) => $user->isProPlus()); // Pro+ posts free; others pay per post
Gate::define('view-profile-analytics', fn($user) => $user->isPro());
Gate::define('boost-search', fn($user) => $user->isPro());
```

### Search boost
When indexing profiles in Meilisearch, set a `boost_weight` field:
- Free: 1
- Pro: 2  
- Pro+: 3

Use Meilisearch ranking rules to surface higher-weight profiles first within the same relevance band.

---

## Messaging

- All messages are stored on-platform (do not push to external services)
- Conversations are between two verified, active members only
- Accounts with `status = pending` cannot send or respond to any messages — messaging is fully blocked until `status = active`. They may see their inbox but all compose and reply actions are disabled with a prompt to complete verification.
- Rate limit cold outreach: max 20 new conversation starts per day per user (database rate limiter via `RateLimiter` facade)

### Message scanning
On every message send, run a keyword scan for payment-related language:

```php
$paymentKeywords = [
    'send payment', 'bank transfer', 'cash app', 'venmo', 'paypal', 
    'invoice', 'upfront', 'advance', '£', '$', 'fee', 'charge',
    'pay me', 'bank details', 'sort code', 'account number',
];
```

If triggered:
1. Set `flagged = true` on the Message record
2. Deliver the message normally — do not show any warning to the recipient
3. Log to `VerificationLog` for admin review

### Reporting
- Every conversation thread shows a "Report this member" button
- Report form: reason dropdown + free text
- On 3 independent reports from different users: auto-suspend the reported account, notify admin
- Admin reviews within 24 hours

---

## Search & discovery

Use Laravel Scout with Meilisearch.

### Searchable fields (Profile + User join)
- display_name, bio, genres, location, role
- social_links (indexed but not displayed)

### Filters available to users
- Role (songwriter, composer, producer, etc.)
- Genre
- Location / country
- Verified badge (id_verified, producer_verified, publisher_verified)
- Pro member (boolean)

### Ranking
- Promoted profiles appear in a separate "Featured" row above search results (not mixed in)
- Within results: Pro+ > Pro > Free (boost_weight), then by profile completeness score, then recency

---

## Brief board

### Listing page (`/briefs`)
- All verified members (including Free) can browse, read, and apply to briefs
- Filter by category, genre, compensation type
- Free members have full access to all brief functionality — browse, read, apply, and message shortlisted applicants

### Posting a brief
- Any verified member can post a brief (Free, Pro, or Pro+)
- Free and Pro members pay a one-off posting fee of £7 per brief via Stripe Checkout
- Pro+ members can post briefs at no additional cost (included in tier)
- Brief form: title, description, category, genres, compensation type, deadline
- Brief expires after 30 days — send reminder email at day 25, expire at day 30
- Expired briefs move to an archive view

### Applying to a brief
- Any verified member can apply
- Application: 200-word pitch + optional portfolio item selection
- One application per brief per user
- Poster receives notification, can view applicants in a shortlist view
- Poster can message shortlisted applicants directly (opens a conversation)

---

## AI content detection

Use the Anthropic Claude API to scan bio text and portfolio lyric submissions.

```php
// Example prompt for bio scanning
$prompt = "You are a content moderation assistant. Analyse the following text and determine if it appears to be AI-generated rather than written by a real person. Look for: overly generic descriptions, marketing-speak, lack of specific personal details, repetitive sentence structures, and claims that seem fabricated. Respond with JSON only: {\"ai_likely\": true/false, \"confidence\": 0.0-1.0, \"reason\": \"brief reason\"}. Text to analyse: \"{$bio}\"";
```

- If `ai_likely = true` and `confidence > 0.7`: flag the profile for review, show a soft warning to the user asking them to personalise their bio
- Do not hard-block — log and flag only
- Run on: bio submission, portfolio lyric uploads

---

## Profile photo flagging

Use a simple heuristic check:
- On profile photo upload, store the image
- Send to a moderation queue
- Admin reviews flagged photos in the admin panel
- Optionally: use a third-party API (e.g. AWS Rekognition or Anthropic vision) to detect stock photo characteristics

For now, implement as a manual admin review queue — do not auto-reject.

---

## Admin panel

Build a simple admin panel at `/admin` (middleware: `role:admin`).

### Sections required
1. **Verification queue** — list of accounts with `id_verification_status = review`. Actions: approve, reject, request more info.
2. **Report queue** — open reports. Actions: suspend user, dismiss report, warn user.
3. **Producer badge queue** — unverifiable producer credit claims. Actions: grant badge, reject, request evidence.
4. **Suspended accounts** — list with reinstatement button.
5. **Promoted profiles** — manage active promotions, add manual promotions.
6. **Member search** — search all members, view full profile, impersonate (for support).
7. **Stats dashboard** — signups today/week/month, verification pass rate, report count, subscription counts by tier.

---

## Notifications

Use Laravel Notifications (database + email channels).

Events to notify on:
- New connection request received
- Connection request accepted
- New message received (email digest: max 1 email per hour per user)
- Brief application received (poster notified)
- Brief shortlisted (applicant notified)
- Brief expiring in 5 days
- Account verified successfully
- Account suspended (with reason)
- Report acknowledged
- Promoted profile starting / ending

---

## Key routes

```
GET  /                          → Marketing landing page
GET  /join                      → Onboarding step 1 (role selection)
GET  /onboarding/{step}         → Onboarding steps 2–10
GET  /dashboard                 → Authenticated member dashboard
GET  /members                   → Member search/browse
GET  /members/{slug}            → Public profile view
GET  /messages                  → Inbox
GET  /messages/{conversationId} → Conversation thread
GET  /briefs                    → Brief board listing
GET  /briefs/{id}               → Single brief view
POST /briefs/{id}/apply         → Submit brief application
GET  /briefs/create             → Post a brief (Pro+ or paid)
GET  /profile/edit              → Edit own profile
GET  /settings                  → Account settings, subscription management
GET  /admin                     → Admin panel (role:admin only)
```

---

## Security & compliance

- All routes behind auth except: landing page, `/join`, public profile pages (`/members/{slug}`)
- CSRF protection on all forms (Laravel default)
- Rate limiting:
  - Login: 5 attempts per minute
  - SMS send: 3 per phone per hour
  - Message send: 20 new conversations per day per user (Redis)
  - Brief applications: 10 per day per user
- GDPR:
  - Privacy policy and terms required before completing onboarding (step 9)
  - Data export endpoint: `/settings/export-data` — generates JSON of all user data
  - Account deletion: soft-delete user, anonymise messages, retain financial records
- No raw ID documents stored — Stripe Identity handles all document data
- Phone numbers stored hashed (bcrypt) — checked for uniqueness via hash comparison only

---

## Environment variables required

```env
STRIPE_KEY=
STRIPE_SECRET=
STRIPE_WEBHOOK_SECRET=
STRIPE_IDENTITY_PRICE_ID=
STRIPE_PRO_ANNUAL_PRICE_ID=
STRIPE_PRO_6MONTH_PRICE_ID=
STRIPE_PRO_3MONTH_PRICE_ID=
STRIPE_PRO_PLUS_ANNUAL_PRICE_ID=
STRIPE_PRO_PLUS_6MONTH_PRICE_ID=
STRIPE_PRO_PLUS_3MONTH_PRICE_ID=
STRIPE_BRIEF_POST_PRICE_ID=
TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=
ANTHROPIC_API_KEY=
MEILISEARCH_HOST=
MEILISEARCH_KEY=
POSTMARK_TOKEN=
COMPANIES_HOUSE_API_KEY=
```

---

## Build order (suggested phases)

### Phase 1 — Foundation
1. Laravel install, auth scaffolding (Breeze + Livewire + Blade stack)
2. Database migrations for all models above
3. Basic routing structure
4. Tailwind CSS + base Blade layout components

### Phase 2 — Onboarding & verification
5. Multi-step onboarding Livewire component (`OnboardingWizard`)
6. Stripe Identity integration (webhooks)
7. Twilio SMS verification
8. Stripe joining fee (one-time Checkout Session)
9. Subscription plan selection + Stripe one-time Checkout Sessions (annual / 6-month / 3-month)
10. Scheduled job: `CheckExpiredSubscriptions` — downgrade expired subscribers, send renewal reminders

### Phase 3 — Core platform
10. Profile pages (view + edit)
11. Member search with Meilisearch
12. Messaging (conversations + messages + scanning)
13. Connection requests
14. Portfolio upload

### Phase 4 — Monetisation features
15. Brief board (listing, posting, applying)
16. Promoted profiles
17. Pro feature gates (analytics, search boost, unlimited portfolio)
18. Profile analytics (views tracking)

### Phase 5 — Trust & admin
19. Report system + auto-suspend logic
20. Admin panel (all sections)
21. Higher verification flows (producer, publisher)
22. AI bio scanning (Anthropic API)
23. Notifications (database + email)

### Phase 6 — Polish
24. Dashboard (suggested connections, activity feed)
25. Credits page / CV export (PDF)
26. Split sheet generator
27. Email digest notifications
28. SEO (meta tags, sitemap, public profile indexing)

---

## Notes for Claude Code

- Follow Laravel conventions throughout — use Eloquent, Form Requests, Resource classes, Policies
- All financial logic goes through Stripe — never store card details or raw payment data
- Every database write that involves user trust status should log to `VerificationLog`
- Use Livewire components for all interactive UI — keep components small and focused, one responsibility per component
- No Inertia, no Vue, no npm build pipeline — Blade + Livewire + Alpine.js only
- Tailwind can be loaded via CDN for development; use a pre-compiled stylesheet for production if the hosting environment supports it, otherwise CDN is acceptable
- Queue driver is `database` — ensure `php artisan queue:work` runs via the hosting scheduler (cron). All async jobs (email, AI scanning, verification webhooks) go through the queue
- File uploads go to the hosting provider's local disk storage via Laravel's `local` filesystem driver. Use `Storage::disk('local')` — do not reference S3 or cloud storage
- Use Postmark for all transactional email (`MAIL_MAILER=postmark`). Install `symfony/postmark-mailer`
- When in doubt on UI patterns: clean, professional, minimal — this is a B2B-adjacent music industry tool, not a consumer social app
- The verified badge should be visually prominent on profile cards, search results, and message threads — it is central to the platform's trust proposition
- Subscription expiry is managed by the `CheckExpiredSubscriptions` scheduled job — never trust `subscription_tier` alone without also checking `subscription_expires_at`

---

## Cold start strategy

This section is not a build requirement but provides essential context for launch sequencing and certain UI decisions noted below.

### Background

Verse-chorus.com (a separate existing platform) remains live and operational — it is not being shut down. Songwriterlink is a distinct product with a different model (ID-verified, free messaging). Verse-chorus members are a natural early audience but should be invited to join Songwriterlink as an additional platform, not migrated away from verse-chorus. Both platforms serve the same broad audience but with different propositions.

### Phase 0 — Pre-launch (4–6 weeks before opening)

**Founding member programme**
- Personally recruit 20–50 real founding members from your existing network and from verse-chorus
- Offer: 12 months Pro free + permanent "Founding Member" badge on their profile
- Cap at 50 slots — scarcity makes it meaningful
- Require profile completion within 2 weeks of joining, or the slot is released
- Ask each founding member to invite one other person they know in the industry
- The Founding Member badge must never be removed from their profile — it is a permanent early adopter signal

**Private beta period**
- Founding members complete profiles before public launch
- Ask 3–5 founding producers/publishers to post at least one genuine brief before launch day
- When the site opens publicly it already has 20–50 real profiles and 5+ open briefs — first arrivals see a community, not an empty room

**Waitlist landing page**
- Publish a waitlist page 4–6 weeks before launch
- Show a live counter: "47 verified songwriters already signed up" — update weekly
- Verse-chorus: add a banner linking to the Songwriterlink waitlist ("We're launching a new platform — get founding member access")

### Phase 1 — Launch (weeks 1–4)

**Retention**
- Send a personal (non-automated) welcome email to every member for the first 100 signups
- Show membership number on the dashboard: "You are member #34" — creates early adopter identity
- Weekly digest email: new members this week, new briefs posted, featured profiles
- Onboarding checklist with progress nudge: "Your profile is 60% complete"

**Activation**
- On first login after completing onboarding, suggest 3 specific members to connect with (matched by role + genre) — never show an empty "suggested connections" widget
- New member announcement in the activity feed: "Welcome [name], a songwriter from Manchester"
- If no briefs match their genre, show: "Be the first to post a brief in [genre]"

**Verse-chorus cross-promotion**
- Frame Songwriterlink as complementary: "More verified, more open — a different kind of network"
- Offer verse-chorus members a discounted first year: £50 instead of £80 annual Pro (migration discount code)
- Do not auto-import verse-chorus accounts — all members must register fresh and complete ID verification. This is a feature, not a limitation: it is precisely what makes the new platform trustworthy.

### UI decisions driven by cold start

These specific UI behaviours exist to manage the appearance of a healthy, active community during the growth phase. They are honest signals — nothing is fabricated — but they are chosen to show the platform in its best light at low member counts.

**Member search**
- Default sort: most complete profiles first — not newest. This ensures early visitors see polished, complete profiles rather than just-registered empty ones.

**Brief board**
- Do not show the brief board publicly until at least 5 real briefs are posted. Gate the `/briefs` route with a `BriefBoardLive` feature flag (stored in config or the database) that an admin can enable manually.
- Sort briefs by "recently active" (last application or edit) not "newest" — keeps older briefs visible and the board looking busier.

**Member count**
- Do not display total member count publicly until the platform reaches 200+ verified members. Until then, show "A growing community of verified songwriters" in marketing copy. Add a `show_member_count` feature flag (admin-togglable) to the homepage and marketing pages.

**Activity signals**
- Show "X new members this week" and "X briefs posted this month" on the dashboard — weekly/monthly windows look healthier than cumulative totals at low numbers.
- Featured member carousel on the homepage: rotate through verified profiles with complete profiles and at least one portfolio item. Never show empty slots — if fewer than 3 qualifying profiles exist, show 1 or 2 rather than placeholder cards.

### Feature flags to implement

Add a simple `feature_flags` table or config array for admin-togglable launch controls:

```php
// config/features.php
return [
    'brief_board_live'    => env('FEATURE_BRIEF_BOARD_LIVE', false),
    'show_member_count'   => env('FEATURE_SHOW_MEMBER_COUNT', false),
    'founding_members_open' => env('FEATURE_FOUNDING_MEMBERS_OPEN', true),
];
```

Admin panel should include a "Feature flags" section to toggle these without a deployment.
