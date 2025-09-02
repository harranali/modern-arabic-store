<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page with cart items and total amount.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        return Inertia::render('Checkout/Index', [
            'cartItems' => array_values($cart),
            'total' => $total,
        ]);
    }

    /**
     * Process the checkout by simulating a payment.
     *
     * This method generates a simulated order with a unique ID,
     * calculates the total, marks it as paid, and clears the cart session.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['message' => 'السلة فارغة'], 422);
        }

        $order = [
            'id' => Str::upper(Str::random(8)),
            'items' => $cart,
            'total' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart)),
            'status' => 'paid_simulated',
            'paid_at' => now()->toDateTimeString()
        ];

        session()->forget('cart');

        return response()->json([
            'message' => 'الدفع تم (محاكاة)',
            'order' => $order
        ]);
    }

    /**
     * Display the order confirmation page after checkout.
     *
     * @return \Inertia\Response
     */
    public function confirm()
    {
        return Inertia::render('Checkout/Confirm');
    }
}
