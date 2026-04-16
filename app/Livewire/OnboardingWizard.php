<?php

namespace App\Livewire;

use App\Http\Controllers\StripeIdentityController;
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

    // Step 5 — Profile
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

    // Step 6 — Photo
    public $photo = null;

    // Step 8 — Plan
    public string $selectedPlan = 'free';
    public string $selectedTerm = 'annual';

    public function mount(int|string $step = 1): void
    {
        $step = (int) $step;

        if (auth()->check()) {
            $user = auth()->user();

            // Completed onboarding — go to dashboard
            if ($user->status === 'active') {
                $this->redirect(route('dashboard'), navigate: true);
                return;
            }

            // Steps 3+ require a verified email address
            if ($step > 2 && ! $user->hasVerifiedEmail()) {
                $this->redirect(route('verification.notice'), navigate: true);
                return;
            }

            // Don't let them skip ahead
            $this->currentStep = min($step, $user->onboarding_step);

            // Pre-fill step 5 if profile exists
            if ($profile = $user->profile) {
                $this->displayName    = $profile->display_name ?? '';
                $this->bio            = $profile->bio ?? '';
                $this->location       = $profile->location ?? '';
                $this->country        = $profile->country ?? '';
                $this->selectedGenres = $profile->genres ?? [];
                $this->socialLinks    = array_merge($this->socialLinks, $profile->social_links ?? []);
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

    // ─── Step 3: Joining fee ──────────────────────────────────────────────────

    public function skipJoiningFee(): void
    {
        // Dev-mode only bypass — production uses Stripe Checkout
        auth()->user()->update(['onboarding_step' => 4]);
        $this->redirect(route('onboarding.step', 4), navigate: true);
    }

    public function waiveJoiningFeeForUpgrade(): void
    {
        // User chose to pay via Pro/Pro+ subscription instead.
        // Mark fee as paid (it'll be covered by the subscription checkout in step 8).
        auth()->user()->update([
            'joining_fee_paid'    => true,
            'joining_fee_paid_at' => now(),
            'onboarding_step'     => 4,
        ]);
        $this->redirect(route('onboarding.step', 4), navigate: true);
    }

    // ─── Step 4: ID verification ──────────────────────────────────────────────

    public function skipIdVerification(): void
    {
        // Dev-mode bypass only — marks user as fully verified so the app
        // behaves exactly as it would after a real Stripe Identity pass.
        auth()->user()->update([
            'id_verified'            => true,
            'id_verified_at'         => now(),
            'id_verification_status' => 'passed',
            'onboarding_step'        => 5,
        ]);
        $this->redirect(route('onboarding.step', 5), navigate: true);
    }

    // TODO: Stripe Identity session creation (Phase 2, item 6)
    // Webhook: identity.verification_session.verified → id_verified = true, status = passed
    // Webhook: requires_input (2nd fail) → status = review, notify admin

    // ─── Step 5: Profile setup ────────────────────────────────────────────────

    public function toggleGenre(string $genre): void
    {
        if (in_array($genre, $this->selectedGenres)) {
            $this->selectedGenres = array_values(array_filter(
                $this->selectedGenres,
                fn ($g) => $g !== $genre
            ));
        } else {
            $this->selectedGenres[] = $genre;
        }
    }

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

        $user->update(['onboarding_step' => 6]);
        $this->redirect(route('onboarding.step', 6), navigate: true);
    }

    // ─── Step 6: Profile photo ────────────────────────────────────────────────

    public function savePhoto(): void
    {
        $this->validate(['photo' => 'nullable|image|max:4096']);

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            auth()->user()->profile()->update(['profile_photo_path' => $path]);
        }

        auth()->user()->update(['onboarding_step' => 7]);
        $this->redirect(route('onboarding.step', 7), navigate: true);
    }

    public function skipPhoto(): void
    {
        auth()->user()->update(['onboarding_step' => 7]);
        $this->redirect(route('onboarding.step', 7), navigate: true);
    }

    // ─── Step 7: Portfolio upload ─────────────────────────────────────────────

    public function skipPortfolio(): void
    {
        auth()->user()->update(['onboarding_step' => 8]);
        $this->redirect(route('onboarding.step', 8), navigate: true);
    }

    // TODO: Portfolio upload logic (Phase 3, item 14)

    // ─── Step 8: Plan selection ───────────────────────────────────────────────

    public function selectPlan(): void
    {
        $this->validate([
            'selectedPlan' => 'required|in:free,pro,pro_plus',
            'selectedTerm' => 'required|in:annual,six_month,three_month',
        ]);

        if ($this->selectedPlan === 'free') {
            $this->activateFree();
            return;
        }

        // Paid plan — hand off to Stripe Checkout
        $this->redirect(
            route('checkout.subscription.start', [
                'plan' => $this->selectedPlan,
                'term' => $this->selectedTerm,
            ])
        );
    }

    public function selectPlanDev(): void
    {
        // Dev-mode only: activate without payment
        $this->validate([
            'selectedPlan' => 'required|in:free,pro,pro_plus',
            'selectedTerm' => 'required|in:annual,six_month,three_month',
        ]);

        $expiresAt = match ($this->selectedTerm) {
            'annual'      => now()->addYear(),
            'six_month'   => now()->addMonths(6),
            'three_month' => now()->addMonths(3),
            default       => now()->addYear(),
        };

        auth()->user()->update([
            'subscription_tier'       => $this->selectedPlan,
            'subscription_expires_at' => $this->selectedPlan !== 'free' ? $expiresAt : null,
            'subscription_term'       => $this->selectedPlan !== 'free' ? $this->selectedTerm : null,
            'joining_fee_paid'        => true,
            'status'                  => 'active',
            'onboarding_step'         => 9,
        ]);

        $this->redirect(route('onboarding.step', 9), navigate: true);
    }

    private function activateFree(): void
    {
        auth()->user()->update([
            'subscription_tier' => 'free',
            'status'            => 'active',
            'onboarding_step'   => 9,
        ]);

        $this->redirect(route('onboarding.step', 9), navigate: true);
    }

    // ─── Back navigation ─────────────────────────────────────────────────────

    public function goBack(): void
    {
        // Steps 1-3 have no in-wizard back (pre-registration or can't undo)
        if ($this->currentStep > 3) {
            $this->currentStep--;
        }
    }

    // ─── Step 4: Identity status polling ─────────────────────────────────────

    /**
     * Called every 5 seconds by wire:poll when the user is on step 4 with a
     * pending verification. Checks the Stripe API directly so it works in local
     * dev (where webhooks can't reach the server) as well as production.
     */
    public function pollIdentityStatus(): void
    {
        if ($this->currentStep !== 4) {
            return;
        }

        $user = auth()->user()->fresh();

        // Already skipped via dev bypass
        if ($user->id_verified) {
            $this->redirect(route('onboarding.step', 5), navigate: true);
            return;
        }

        // Don't hit the Stripe API in local dev — use the skip button instead
        if (app()->isLocal()) {
            return;
        }

        if (StripeIdentityController::pollStatus($user)) {
            $this->redirect(route('onboarding.step', 5), navigate: true);
        }
    }

    // ─── Render ───────────────────────────────────────────────────────────────

    public function render()
    {
        return view('livewire.onboarding-wizard');
    }
}
