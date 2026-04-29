<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class StripeCheckoutController extends Controller
{
    // ── Pricing table ─────────────────────────────────────────────────────────

    private const PRICES = [
        'pro' => [
            'annual'      => ['pence' => 8000,  'label' => 'Pro — Annual'],
            'six_month'   => ['pence' => 4500,  'label' => 'Pro — 6 months'],
            'three_month' => ['pence' => 2500,  'label' => 'Pro — 3 months'],
        ],
        'pro_plus' => [
            'annual'      => ['pence' => 18000, 'label' => 'Pro+ — Annual'],
            'six_month'   => ['pence' => 10000, 'label' => 'Pro+ — 6 months'],
            'three_month' => ['pence' => 5500,  'label' => 'Pro+ — 3 months'],
        ],
    ];

    // ── Joining fee ───────────────────────────────────────────────────────────

    public function startJoiningFee(Request $request)
    {
        $user = auth()->user();

        if ($user->joining_fee_paid) {
            $this->advanceIfNeeded($user, 4);
            return redirect()->route('onboarding.step', 4);
        }

        $stripe  = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->create([
            'mode'                 => 'payment',
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'gbp',
                    'unit_amount'  => 400,
                    'product_data' => [
                        'name'        => 'SongwriterLink joining fee',
                        'description' => 'One-time fee to join the verified SongwriterLink community',
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata'    => ['user_id' => (string) $user->id, 'type' => 'joining_fee'],
            'success_url' => route('checkout.joining-fee.return') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('onboarding.step', 3),
        ]);

        return redirect($session->url);
    }

    public function joiningFeeReturn(Request $request)
    {
        $user      = auth()->user();
        $sessionId = $request->query('session_id');

        if ($user->joining_fee_paid) {
            $this->advanceIfNeeded($user, 4);
            return redirect()->route('onboarding.step', 4)
                ->with('status', 'Joining fee already paid — continuing.');
        }

        if (! $sessionId) {
            return redirect()->route('onboarding.step', 3)
                ->with('error', 'Payment session not found. Please try again.');
        }

        try {
            $stripe  = new StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect()->route('onboarding.step', 3)
                ->with('error', 'Could not verify payment. Please contact support.');
        }

        if ($session->payment_status === 'paid' && (string) $session->metadata->user_id === (string) $user->id) {
            $this->markJoiningFeePaid($user, $session->id);
            return redirect()->route('onboarding.step', 4)
                ->with('status', 'Joining fee paid — welcome to SongwriterLink!');
        }

        return redirect()->route('onboarding.step', 3)
            ->with('error', 'Payment was not completed. Please try again.');
    }

    // ── Subscription ──────────────────────────────────────────────────────────

    public function startSubscription(Request $request)
    {
        $plan   = $request->query('plan');
        $term   = $request->query('term');
        $source = $request->query('source', 'onboarding'); // 'onboarding' | 'settings'

        if (! isset(self::PRICES[$plan][$term])) {
            $cancelRoute = $source === 'settings'
                ? route('settings.subscription')
                : route('onboarding.step', 8);
            return redirect($cancelRoute)->with('error', 'Invalid plan or term selected.');
        }

        $user = auth()->user();

        // Already on an active paid plan — skip ahead (onboarding only)
        if ($user->isPro() && $source === 'onboarding') {
            $this->advanceIfNeeded($user, 9);
            return redirect()->route('onboarding.step', 9);
        }

        $price = self::PRICES[$plan][$term];

        $successUrl = route('checkout.subscription.return')
            . '?session_id={CHECKOUT_SESSION_ID}&source=' . $source;

        $cancelUrl = $source === 'settings'
            ? route('settings.subscription')
            : route('onboarding.step', 8);

        $stripe  = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->create([
            'mode'                 => 'payment',
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'gbp',
                    'unit_amount'  => $price['pence'],
                    'product_data' => ['name' => $price['label']],
                ],
                'quantity' => 1,
            ]],
            'metadata'    => [
                'user_id' => (string) $user->id,
                'type'    => 'subscription',
                'plan'    => $plan,
                'term'    => $term,
                'source'  => $source,
            ],
            'success_url' => $successUrl,
            'cancel_url'  => $cancelUrl,
        ]);

        return redirect($session->url);
    }

    public function subscriptionReturn(Request $request)
    {
        $user      = auth()->user();
        $sessionId = $request->query('session_id');
        $source    = $request->query('source', 'onboarding');

        $isSettings = $source === 'settings';

        // Already handled (e.g. webhook beat us to it)
        if ($user->isPro()) {
            if ($isSettings) {
                return redirect()->route('settings.subscription')
                    ->with('status', 'Your subscription is now active!');
            }
            $this->advanceIfNeeded($user, 9);
            return redirect()->route('onboarding.step', 9)
                ->with('status', 'Subscription activated — you\'re all set!');
        }

        $errorRoute = $isSettings ? route('settings.subscription') : route('onboarding.step', 8);

        if (! $sessionId) {
            return redirect($errorRoute)->with('error', 'Payment session not found. Please try again.');
        }

        try {
            $stripe  = new StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect($errorRoute)->with('error', 'Could not verify payment. Please contact support.');
        }

        if ($session->payment_status === 'paid' && (string) $session->metadata->user_id === (string) $user->id) {
            $this->activateSubscription(
                $user,
                $session->metadata->plan,
                $session->metadata->term,
                $session->id
            );

            if ($isSettings) {
                return redirect()->route('settings.subscription')
                    ->with('status', 'Subscription upgraded — enjoy your new plan!');
            }
            return redirect()->route('onboarding.step', 9)
                ->with('status', 'Subscription activated — welcome to SongwriterLink!');
        }

        return redirect($errorRoute)->with('error', 'Payment was not completed. Please try again.');
    }

    // ── Webhook handler (production belt-and-braces) ──────────────────────────

    public static function handleWebhookCheckoutCompleted(object $session): void
    {
        $type   = $session->metadata->type ?? '';
        $userId = $session->metadata->user_id ?? null;
        $user   = User::find($userId);

        if (! $user) return;

        if ($type === 'joining_fee' && ! $user->joining_fee_paid) {
            (new self())->markJoiningFeePaid($user, $session->id);
            return;
        }

        if ($type === 'subscription' && ! $user->isPro()) {
            (new self())->activateSubscription(
                $user,
                $session->metadata->plan ?? 'pro',
                $session->metadata->term ?? 'annual',
                $session->id
            );
        }
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function markJoiningFeePaid(User $user, string $sessionId): void
    {
        $user->update([
            'joining_fee_paid'    => true,
            'joining_fee_paid_at' => now(),
            'onboarding_step'     => max($user->onboarding_step, 4),
        ]);
    }

    private function activateSubscription(User $user, string $plan, string $term, string $sessionId): void
    {
        $expiresAt = match ($term) {
            'annual'      => now()->addYear(),
            'six_month'   => now()->addMonths(6),
            'three_month' => now()->addMonths(3),
            default       => now()->addYear(),
        };

        $user->update([
            'subscription_tier'       => $plan,
            'subscription_expires_at' => $expiresAt,
            'subscription_term'       => $term,
            'joining_fee_paid'        => true,       // subscription covers the joining fee
            'joining_fee_paid_at'     => $user->joining_fee_paid_at ?? now(),
            'status'                  => 'active',
            'onboarding_step'         => max($user->onboarding_step, 9),
        ]);
    }

    private function advanceIfNeeded(User $user, int $step): void
    {
        if ($user->onboarding_step < $step) {
            $user->update(['onboarding_step' => $step]);
        }
    }
}
