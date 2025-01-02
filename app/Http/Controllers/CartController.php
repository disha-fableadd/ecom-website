<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');

        $cart = Cart::where('uid', $userId)->where('pid', $productId)->first();

        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Product has been Updated Sucessfully!'
            ]);
        } else {
            Cart::create([
                'uid' => $userId,
                'pid' => $productId,
                'quantity' => 1
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Product has been added to your cart!'
            ]);

        }
        return redirect()->route('cart.page')->with('success', 'Product added to cart!');
    }



    public function showCart()
    {
        $user = session('user');
        $cartCount = 0;

        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }

        $userId = $user ? $user->id : 0;

        $cartItems = Cart::where('uid', $userId)->get();

        $grandTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'grandTotal', 'cartCount'));
    }




    public function updateCart(Request $request)
    {
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');

        $cartItem = Cart::find($cartId);
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function removeItem(Request $request)
    {
        $cartId = $request->input('cart_id');
        $cartItem = Cart::find($cartId);

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
