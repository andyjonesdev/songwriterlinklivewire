<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        }

        match ($event->type) {
            'identity.verification_session.verified'       => $this->handleVerified($event->data->object),
            'identity.verification_session.requires_input' => $this->handleRequiresInput($event->data->object),
            'checkout.session.completed'                   => StripeCheckoutController::handleWebhookCheckoutCompleted($event->data->object),
            default => null,
        };

        return response('OK', 200);
    }

    // ── Verified ──────────────────────────────────────────────────────────────

    private function handleVerified(object $session): void
    {
        $user = User::where('stripe_identity_session_id', $session->id)->first();
        if (! $user) return;

        $user->update([
            'id_verified'            => true,
            'id_verified_at'         => now(),
            'id_verification_status' => 'passed',
            'onboarding_step'        => max($user->onboarding_step, 5),
        ]);

        VerificationLog::create([
            'user_id'    => $user->id,
            'event'      => 'id_check_passed',
            'detail'     => ['session_id' => $session->id],
            'created_at' => now(),
        ]);
    }

    // ── Requires input (failed / needs retry) ─────────────────────────────────

    private function handleRequiresInput(object $session): void
    {
        $user = User::where('stripe_identity_session_id', $session->id)->first();
        if (! $user) return;

        $reason = $session->last_error->reason ?? 'unknown';

        // Second failure → manual review queue
        if ($user->id_verification_status === 'failed') {
            $user->update(['id_verification_status' => 'review']);

            VerificationLog::create([
                'user_id'    => $user->id,
                'event'      => 'id_check_failed',
                'detail'     => [
                    'session_id' => $session->id,
                    'reason'     => $reason,
                    'attempt'    => 2,
                    'note'       => 'Second failure — queued for admin review',
                ],
                'created_at' => now(),
            ]);

            // TODO: notify admin via notification (Phase 5, item 23)

        } else {
            // First failure — let them retry with a new session
            $user->update(['id_verification_status' => 'failed']);

            VerificationLog::create([
                'user_id'    => $user->id,
                'event'      => 'id_check_failed',
                'detail'     => [
                    'session_id' => $session->id,
                    'reason'     => $reason,
                    'attempt'    => 1,
                ],
                'created_at' => now(),
            ]);
        }
    }
}
