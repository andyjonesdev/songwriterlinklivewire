<?php

namespace App\Livewire;

use App\Models\Profile;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.onboarding')]
class OnboardingWizard extends Component
{
    use WithFileUploads;

    public int $currentStep = 1;

    // Step 1 — Role
    public string $role = 'songwriter';

    // Step 3 — Phone
    public string $phone = '';
    public string $smsCode = '';
    public bool $smsSent = false;

    // Step 6 — Profile
    public string $displayName = '';
    public string $bio = '';
    public string $location = '';
    public string $country = '';
    public array $selectedGenres = [];
    public array $socialLinks = [
        'spotify'    => '',
        'soundcloud' => '',
        'imdb'       => '',
        'linkedin'   => '',
        'prs_ascap'  => '',
        'discogs'    => '',
    ];

    // Step 7 — Photo
    public $photo = null;

    // Step 9 — Plan
    public string $selectedPlan = 'free';
    public string $selectedTerm = 'annual';

    public function mount(int|string $step = 1): void
    {
        $step = (int) $step;
    }

    /** @phpstan-ignore-next-line */
    private function _mount(int $step = 1): void
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Completed onboarding — go to dashboard
            if ($user->status === 'active') {
                $this->redirect(route('dashboard'), navigate: true);
                return;
            }

            // Don't let them skip ahead
            $this->currentStep = min($step, $user->onboarding_step);

            // Pre-fill step 6 if profile exists
            if ($profile = $user->profile) {
                $this->displayName   = $profile->display_name ?? '';
                $this->bio           = $profile->bio ?? '';
                $this->location      = $profile->location ?? '';
                $this->country       = $profile->country ?? '';
                $this->selectedGenres = $profile->genres ?? [];
                $this->socialLinks   = array_merge($this->socialLinks, $profile->social_links ?? []);
            }

            $this->role = $user->role;
        } else {
            // Guests can only be on step 1
            if ($step > 1) {
                $this->redirect(route('login'), navigate: true);
                return;
            }
            $this->currentStep = 1;
        }
    }

    // ─── Step 1: Role ─────────────────────────────────────────────────────────

    public function submitRole(): void
    {
        $this->validate(['role' => 'required|in:songwriter,composer,producer,publisher,other']);
        session(['onboarding_role' => $this->role]);
        $this->redirect(route('register'), navigate: true);
    }

    // ─── Step 3: Phone verification ───────────────────────────────────────────

    public function sendSmsCode(): void
    {
        $this->validate(['phone' => 'required|string|min:7|max:20']);

        // TODO: Twilio integration (Phase 2, item 7)
        // \Twilio\Rest\Client::messages->create($this->phone, [...])
        // Store code hash in cache keyed by phone

        $this->smsSent = true;
        session()->flash('status', 'Code sent — check your phone.');
    }

    public function verifyPhone(): void
    {
        $this->validate(['smsCode' => 'required|digits:6']);

        // TODO: Verify code against Twilio / cache
        // Check phone is not already used by another active account (fail silently, flag for review)

        $user = auth()->user();
        $user->update([
            'phone'            => $this->phone,
            'phone_verified_at' => now(),
            'onboarding_step'  => 4,
        ]);

        $this->redirect(route('onboarding.step', 4), navigate: true);
    }

    // ─── Step 4: Joining fee ──────────────────────────────────────────────────

    public function skipJoiningFee(): void
    {
        // Advance without payment (local/dev only or if fee waived by plan upgrade)
        auth()->user()->update(['onboarding_step' => 5]);
        $this->redirect(route('onboarding.step', 5), navigate: true);
    }

    // TODO: Stripe joining fee Checkout Session (Phase 2, item 8)
    // Webhook handler will set joining_fee_paid = true and advance step

    // ─── Step 5: ID verification ──────────────────────────────────────────────

    public function skipIdVerification(): void
    {
        // Local bypass only — production uses Stripe Identity webhook
        auth()->user()->update(['onboarding_step' => 6]);
        $this->redirect(route('onboarding.step', 6), navigate: true);
    }

    // TODO: Stripe Identity session creation (Phase 2, item 6)
    // Webhook: identity.verification_session.verified → id_verified = true, status = passed
    // Webhook: requires_input (2nd fail) → status = review, notify admin

    // ─── Step 6: Profile setup ────────────────────────────────────────────────

    public function saveProfile(): void
    {
        $this->validate([
            'displayName'    => 'required|string|max:100',
            'bio'            => 'required|string|min:50|max:1000',
            'location'       => 'nullable|string|max:100',
            'country'        => 'nullable|string|max:100',
            'selectedGenres' => 'required|array|min:1',
            'socialLinks'    => 'array',
        ]);

        $atLeastOneSocialLink = collect($this->socialLinks)->filter()->isNotEmpty();
        if (! $atLeastOneSocialLink) {
            $this->addError('socialLinks', 'Please add at least one social or professional link.');
            return;
        }

        $user = auth()->user();

        // TODO: Claude API bio scan (Phase 2, item 22)
        // $result = app(AiBioScanner::class)->scan($this->bio);

        $slug = \Illuminate\Support\Str::slug($this->displayName) . '-' . $user->id;

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'display_name'  => $this->displayName,
                'slug'          => $slug,
                'bio'           => $this->bio,
                'location'      => $this->location,
                'country'       => $this->country,
                'genres'        => $this->selectedGenres,
                'social_links'  => array_filter($this->socialLinks),
            ]
        );

        $user->update(['onboarding_step' => 7]);
        $this->redirect(route('onboarding.step', 7), navigate: true);
    }

    // ─── Step 7: Profile photo ────────────────────────────────────────────────

    public function savePhoto(): void
    {
        $this->validate(['photo' => 'nullable|image|max:4096']);

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            auth()->user()->profile()->update(['profile_photo_path' => $path]);
        }

        auth()->user()->update(['onboarding_step' => 8]);
        $this->redirect(route('onboarding.step', 8), navigate: true);
    }

    public function skipPhoto(): void
    {
        auth()->user()->update(['onboarding_step' => 8]);
        $this->redirect(route('onboarding.step', 8), navigate: true);
    }

    // ─── Step 8: Portfolio upload ─────────────────────────────────────────────

    public function skipPortfolio(): void
    {
        auth()->user()->update(['onboarding_step' => 9]);
        $this->redirect(route('onboarding.step', 9), navigate: true);
    }

    // TODO: Portfolio upload logic (Phase 3, item 14)

    // ─── Step 9: Plan selection ───────────────────────────────────────────────

    public function selectPlan(): void
    {
        $this->validate([
            'selectedPlan' => 'required|in:free,pro,pro_plus',
            'selectedTerm' => 'required|in:annual,six_month,three_month',
        ]);

        if ($this->selectedPlan === 'free') {
            $this->completeFreeOnboarding();
            return;
        }

        // TODO: Stripe Checkout Session (Phase 2, item 9)
        // Redirect to Stripe. On success webhook: set subscription_tier, subscription_expires_at, then advance to step 10.
        $this->completeFreeOnboarding(); // placeholder
    }

    private function completeFreeOnboarding(): void
    {
        auth()->user()->update([
            'subscription_tier' => $this->selectedPlan,
            'status'            => 'active',
            'onboarding_step'   => 10,
        ]);

        $this->redirect(route('onboarding.step', 10), navigate: true);
    }

    // ─── Render ───────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.onboarding-wizard');
    }
}
