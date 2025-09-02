<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display the current cart contents.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);

        return response()->json($cart);
    }

    /**
     * Add a product to the cart or increase its quantity if it already exists.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'تمت الإضافة إلى السلة',
            'cartCount' => array_sum(array_column($cart, 'quantity')),
            'cartTotal' => array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart))
        ]);
    }

    /**
     * Remove a product from the cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'تمت الإزالة',
            'cart' => $cart
        ]);
    }

    /**
     * Update the quantity of a specific product in the cart.
     * If quantity <= 0, the product is removed.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = (int) $request->quantity;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return response()->json([
            'message' => 'تم التحديث',
            'cart' => $cart
        ]);
    }

    /**
     * Clear the entire cart from the session.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear(Request $request)
    {
        session()->forget('cart');

        return response()->json([
            'message' => 'تمت الإزالة',
            'cart' => []
        ]);
    }
}
