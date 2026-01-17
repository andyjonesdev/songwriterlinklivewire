<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LyricPurchase;
use App\Models\LyricPromote;
use App\Models\User;
use App\Models\Lyric;
use Stripe\Webhook;
use Carbon\Carbon;
use App\Mail\LyricPurchasedMail;
use App\Mail\LyricPromotedMail;
use App\Mail\LyricPurchaseConfirmationMail;
use Illuminate\Support\Facades\Mail;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

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
            $client_reference_id_explode = explode('-', $client_reference_id);
            $type = $client_reference_id_explode[0];
            $user_id = $client_reference_id_explode[1];
            $lyric_id = $client_reference_id_explode[2];
            // echo ', user_id: '.$user_id;
            // echo ', status: '.$status;

            // Fallback: find user by customer email
            // if (!$userId && !empty($session->customer_details->email)) {
            //     $user = User::where('email', $session->customer_details->email)->first();
            //     $userId = $user ? $user->id : null;
            // }

            if ($type=='lyric') {
                if ($user_id && $lyric_id) {
                    $purchase = LyricPurchase::firstOrCreate(
                        ['stripe_session_id' => $session->id],
                        [
                            'user_id' => $user_id,
                            'lyric_id' => $lyric_id,
                            'amount' => $session->amount_total / 100,
                            'currency' => $session->currency,
                        ]
                    );
                }
                Mail::to(config('mail.admin_email', env('ADMIN_EMAIL')))
                ->send(new LyricPurchasedMail($purchase));

                Mail::to($$purchase->user->email)
                    ->send(new LyricPurchaseConfirmationMail($purchase));        
            }
            if ($type=='promote') {
                $bid = $client_reference_id_explode[3];
                $placement = $client_reference_id_explode[4];
                $duration = $client_reference_id_explode[5];
                if ($user_id && $lyric_id) {
                    $purchase = LyricPromote::firstOrCreate(
                        ['stripe_session_id' => $session->id],
                        [
                            'user_id' => $user_id,
                            'lyric_id' => $lyric_id,
                            'placement' => $placement,
                            'duration' => $duration,
                            'bid' => $bid,
                            'amount' => $session->amount_total / 100,
                            'starts_at' => Carbon::now(),
                            'ends_at' => Carbon::now()->addMonth(),
                        ]
                    );
                    Mail::to(config('mail.admin_email', env('ADMIN_EMAIL')))
                    ->send(new LyricPromotedMail($purchase));
                }
            }

            //     Log::info("Lyric purchase recorded: User {$userId}, Lyric {$lyricId}, Session {$session->id}");
            // } else {
            //     Log::warning("Could not record lyric purchase for session {$session->id}");
            // }
        }

        return response()->json(['status' => 'success']);
    }
  //
}
