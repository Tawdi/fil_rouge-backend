<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Models\Seance;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StripeController extends Controller
{
    public function createIntent(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:50', 
                'currency' => 'required|string|in:usd',
                'seance_id' => 'required|exists:seances,id',
                'seats' => 'required|array|min:1',
                'seats.*.row' => 'required|integer|min:0',
                'seats.*.col' => 'required|integer|min:0',
                'seats.*.type' => 'required|string',
            ]);

            Stripe::setApiKey(config('services.stripe.secret'));

            $seance = Seance::find($request->seance_id);
            if (!$seance) {
                return response()->json(['error' => 'Seance not found'], 404);
            }
            // Validate pricing
            $pricing = json_decode($seance->pricing, true);
            if (!$pricing || !is_array($pricing)) {
                return response()->json(['error' => 'Invalid pricing configuration for seance'], 400);
            }

            $seats = $request->seats;

            $calculatedAmount = 0;
            foreach ($seats as $seat) {
                $calculatedAmount += (int) ($pricing[$seat['type']] * 100);
            }

            if ($calculatedAmount !== $request->amount) {
                return response()->json(['error' => 'Amount mismatch'], 400);
            }

            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $calculatedAmount,
                'currency' => $request->currency,
                'payment_method_types' => ['card'],
                'metadata' => [
                    'seance_id' => $request->seance_id,
                    'user_id' => $request->user()->id,
                    'seats' => json_encode($seats),
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Seance not found'], 404);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => 'Payment processing error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }
    
}
