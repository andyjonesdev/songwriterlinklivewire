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
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        // Verify the webhook signature
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        

        return response()->json(['status' => 'success']);
    }
  //
}
