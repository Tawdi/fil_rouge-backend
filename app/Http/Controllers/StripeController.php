<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{


public function createCheckoutSession(Request $request)
{
    $validated = $request->validate([
        'seance_id' => 'required|integer',
        'seats' => 'required|array',
        'seats.*.row' => 'required|integer',
        'seats.*.col' => 'required|integer',
    ]);

    Stripe::setApiKey(env('STRIPE_SECRET'));

    $amount = $this->calculateTotal($validated['seats']);

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Réservation de sièges',
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => config('app.url') . '/payment-success?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => config('app.url') . '/payment-cancelled',
        'metadata' => [
            'user_id' => auth('api')->user()->id,
            'seance_id' => $validated['seance_id'],
            'seats' => json_encode($validated['seats']),
        ]
    ]);

    return response()->json(['id' => $session->id]);
}

private function calculateTotal(array $seats): int
{
    return count($seats) * 1000;
}

}
