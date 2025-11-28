<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;

final class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.pk'));
    }

    public function checkout(): View
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.course')->first();

        return view('stripe.checkout', compact('cart'));
    }

    public function createCheckoutSession(): RedirectResponse
    {
        try {
            $user = Auth::user();
            $cart = $user->cart()->with('items.course')->first();

            if (! $cart || $cart->items->isEmpty()) {
                return redirect()->route('checkout')
                    ->with('error', 'Your cart is empty');
            }

            $lineItems = $cart->items->map(function (CartItem $item) {
                $course = $item->course;

                return [
                    'price_data' => [
                        'currency' => 'gbp',
                        'product_data' => [
                            'name' => $course->name,
                            'description' => mb_substr($course->description, 0, 200), // Limit description length
                            'metadata' => [
                                'course_id' => $course->id,
                            ],
                        ],
                        'unit_amount' => $course->is_free ? 0 : (int) ($course->price * 100), // Convert to cents
                    ],
                    'quantity' => 1,
                ];
            })->toArray();

            $session = Session::create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('stripe.success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout'),
                'customer_email' => $user->email,
                'client_reference_id' => $cart->id,
                'metadata' => [
                    'cart_id' => $cart->id,
                    'user_id' => $user->id,
                ],
            ]);

            return redirect()->away($session->url);

        } catch (ApiErrorException $e) {
            return redirect()->route('checkout')
                ->with('error', 'Payment session creation failed: '.$e->getMessage());
        }
    }

    public function success(Request $request): View
    {
        $sessionId = $request->get('session_id');
        $user = Auth::user();

        try {
            if ($sessionId) {
                $session = Session::retrieve($sessionId);

                $cart = Cart::where('user_id', $user->id)
                    ->first();

                if ($cart && $session->payment_status === 'paid') {

                    $this->processSuccessfulPayment($cart, $session);

                    return view('stripe.success', [
                        'session' => $session,
                        'cart' => $cart,
                    ]);
                }
            }

            return view('stripe.success', [
                'error' => 'Unable to verify payment',
            ]);

        } catch (ApiErrorException $e) {
            return view('stripe.success', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function processSuccessfulPayment(Cart $cart, Session $session): void
    {
        foreach ($cart->items as $item) {

            $cart->user->enrollments()->create([
                'course_id' => $item->course_id,
                'enrolled_at' => now(),
            ]);
        }

        // 3. Clear the cart
        $cart->items()->delete();
        $cart->forceDelete();
    }
}
