<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LyricPurchase;
use App\Models\User;
use App\Models\Lyric;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('whsec_a2NZ21jwJQoBB4mPFO4kOQ34yN8VMiMV');

        // Verify the webhook signature
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle checkout session completed
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Try to get user_id and lyric_id from metadata
            // $userId = $session->metadata->user_id ?? null;
            // $lyricId = $session->metadata->lyric_id ?? null;

            $client_reference_id = $event->data->object->client_reference_id;
            // $subscription = $event->data->object->subscription; //i.e. subscription_id
            // $customer = $event->data->object->customer; //i.e. payer_id
            // $payment_intent = $event->data->object->payment_intent;
            $status = $event->data->object->status;
            echo 'client_reference_id: '.$client_reference_id;
            echo ', '.$status;
            // Fallback: find user by customer email
            // if (!$userId && !empty($session->customer_details->email)) {
            //     $user = User::where('email', $session->customer_details->email)->first();
            //     $userId = $user ? $user->id : null;
            // }

            // // Log the purchase if we have a user and lyric
            // if ($userId && $lyricId) {
            //     LyricPurchase::firstOrCreate(
            //         ['stripe_session_id' => $session->id],
            //         [
            //             'user_id' => $userId,
            //             'lyric_id' => $lyricId,
            //             'amount' => $session->amount_total / 100,
            //             'currency' => $session->currency,
            //         ]
            //     );

            //     Log::info("Lyric purchase recorded: User {$userId}, Lyric {$lyricId}, Session {$session->id}");
            // } else {
            //     Log::warning("Could not record lyric purchase for session {$session->id}");
            // }
        }

        return response()->json(['status' => 'success']);
    }
  //
}
