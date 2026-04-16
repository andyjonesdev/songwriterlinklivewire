<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeIdentityController extends Controller
{
    public function start(Request $request)
    {
        $user = auth()->user();

        // Already verified — skip ahead
        if ($user->id_verified) {
            $this->advanceIfNeeded($user, 5);
            return redirect()->route('onboarding.step', 5);
        }

        // Already in manual review — don't create another session
        if ($user->id_verification_status === 'review') {
            return redirect()->route('onboarding.step', 4)
                ->with('status', 'Your documents are under manual review. We\'ll email you once complete.');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->identity->verificationSessions->create([
            'type'       => 'document',
            'metadata'   => ['user_id' => (string) $user->id],
            'return_url' => route('identity.return'),
            'options'    => [
                'document' => [
                    'allowed_types'           => ['passport', 'driving_license', 'id_card'],
                    'require_live_capture'    => true,
                    'require_matching_selfie' => true,
                ],
            ],
        ]);

        $user->update([
            'stripe_identity_session_id' => $session->id,
            'id_verification_status'     => 'pending',
        ]);

        VerificationLog::create([
            'user_id'    => $user->id,
            'event'      => 'id_check_started',
            'detail'     => ['session_id' => $session->id],
            'created_at' => now(),
        ]);

        return redirect($session->url);
    }

    public function return(Request $request)
    {
        $user = auth()->user();

        // Webhook may have already resolved this
        if ($user->id_verified) {
            $this->advanceIfNeeded($user, 5);
            return redirect()->route('onboarding.step', 5)
                ->with('status', 'Identity verified — you\'re all set.');
        }

        // Actively check the Stripe session status rather than relying solely on
        // the webhook. This is essential in local dev (webhook can't reach the
        // local server) and a useful belt-and-braces in production too.
        if ($user->stripe_identity_session_id) {
            $result = $this->syncSessionStatus($user);
            if ($result === 'verified') {
                return redirect()->route('onboarding.step', 5)
                    ->with('status', 'Identity verified — you\'re all set.');
            }
            if ($result === 'review') {
                return redirect()->route('onboarding.step', 4)
                    ->with('status', 'Your documents are under manual review. We\'ll email you once complete.');
            }
        }

        // Still processing — step 4 will poll until the status resolves
        return redirect()->route('onboarding.step', 4);
    }

    /**
     * Called by the OnboardingWizard Livewire component via polling on step 4.
     * Returns true if the user has now been advanced past this step.
     */
    public static function pollStatus(User $user): bool
    {
        if ($user->id_verified) {
            return true;
        }

        if (! $user->stripe_identity_session_id) {
            return false;
        }

        $controller = new self();
        $result = $controller->syncSessionStatus($user);

        return $result === 'verified';
    }

    /**
     * Retrieve the Stripe session and sync its status to the user record.
     * Returns 'verified', 'review', 'failed', or 'pending'.
     */
    private function syncSessionStatus(User $user): string
    {
        try {
            $stripe  = new StripeClient(config('services.stripe.secret'));
            $session = $stripe->identity->verificationSessions->retrieve(
                $user->stripe_identity_session_id
            );
        } catch (\Exception $e) {
            return 'pending';
        }

        if ($session->status === 'verified') {
            $user->update([
                'id_verified'            => true,
                'id_verified_at'         => now(),
                'id_verification_status' => 'passed',
                'onboarding_step'        => max($user->onboarding_step, 5),
            ]);
            VerificationLog::create([
                'user_id'    => $user->id,
                'event'      => 'id_check_passed',
                'detail'     => ['session_id' => $session->id, 'source' => 'api_poll'],
                'created_at' => now(),
            ]);
            return 'verified';
        }

        if ($session->status === 'requires_input') {
            $reason = $session->last_error?->reason ?? 'unknown';

            if ($user->id_verification_status === 'failed') {
                // Second failure
                $user->update(['id_verification_status' => 'review']);
                VerificationLog::create([
                    'user_id'    => $user->id,
                    'event'      => 'id_check_failed',
                    'detail'     => ['session_id' => $session->id, 'reason' => $reason, 'attempt' => 2, 'source' => 'api_poll'],
                    'created_at' => now(),
                ]);
                return 'review';
            }

            $user->update(['id_verification_status' => 'failed']);
            VerificationLog::create([
                'user_id'    => $user->id,
                'event'      => 'id_check_failed',
                'detail'     => ['session_id' => $session->id, 'reason' => $reason, 'attempt' => 1, 'source' => 'api_poll'],
                'created_at' => now(),
            ]);
            return 'failed';
        }

        return 'pending';
    }

    private function advanceIfNeeded(User $user, int $step): void
    {
        if ($user->onboarding_step < $step) {
            $user->update(['onboarding_step' => $step]);
        }
    }
}
