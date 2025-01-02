<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userr;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function showCheckoutForm()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('login');
        }
        $cartCount = 0; 

        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }

        $cart_items = Cart::where('uid', $user->id)->get();
        $total = $cart_items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout', compact('user', 'cart_items', 'total', 'cartCount'));
    }

    public function placeOrder(Request $request)
    {
        
        $user = session('user');

        if (!$user) {
            return redirect()->route('login');
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Get the cart items for the user
        $cart_items = Cart::with('product')->where('uid', $user->id)->get();
        if ($cart_items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cart_items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Start a transaction
        DB::beginTransaction();

        try {
            // Create the Order
            $order = new Order();
            $order->uid = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address_line_1 = $request->address;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip_code = $request->zip_code;
            $order->total = $total;
            $order->save();

            foreach ($cart_items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->pid = $item->pid;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->save();
            }

            DB::commit();

            Cart::where('uid', $user->id)->delete();

            return redirect()->route('order.success');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('Something went wrong. Please try again.');
        }


    }
}
