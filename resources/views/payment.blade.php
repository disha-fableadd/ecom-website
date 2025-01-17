<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    
    public function createPayment(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to make a payment.');
        }

        $validator = Validator::make($request->all(), [
            'address_line_1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('checkout')->withErrors($validator)->withInput();
        }

        $userId = $user->id;

        $cartItems = Cart::with('product')->where('uid', $userId)->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success'),
                "cancel_url" => route('checkout'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $total,
                    ],
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    DB::beginTransaction();
                    try {
                        $order = new Order();
                        $order->uid = $user->id;
                        $order->first_name = $user->first_name;
                        $order->last_name = $user->last_name;
                        $order->email = $user->email;
                        $order->mobile = $user->mobile;
                        $order->address_line_1 = $request->address_line_1;
                        $order->city = $request->city;
                        $order->state = $request->state;
                        $order->zip_code = $request->zip_code;
                        $order->total = $total;
                        $order->save();

                        foreach ($cartItems as $item) {
                            $orderItem = new OrderItem();
                            $orderItem->order_id = $order->id;
                            $orderItem->pid = $item->pid;
                            $orderItem->quantity = $item->quantity;
                            $orderItem->price = $item->product->price;
                            $orderItem->save();
                        }

                        DB::commit();
                        return redirect()->away($link['href']);
                    } catch (\Exception $e) {
                        DB::rollback();
                        \Log::error('Order creation failed.', ['error' => $e->getMessage()]);
                        return redirect()->route('checkout')->with('error', 'Failed to create order. Please try again.');
                    }
                }
            }
        }

        return redirect()->route('checkout')->with('error', 'Something went wrong with PayPal.');
    }

    public function capturePayment(Request $request)
    {
        \Log::info('PayPal Capture Payment - Token:', ['token' => $request->token]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $response = $provider->capturePaymentOrder($request->query('token'));
            \Log::info('PayPal Capture Payment Response:', ['response' => json_encode($response)]);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $user = session('user');
                if (!$user) {
                    return redirect()->route('login')->with('error', 'You must be logged in to complete the payment.');
                }

                $order = Order::where('uid', $user->id)->latest()->first();
                if (!$order) {
                    return redirect()->route('checkout')->with('error', 'Order not found.');
                }

                Cart::where('uid', $user->id)->delete();

                Transaction::create([
                    'order_id' => $order->id,
                    'payment_method' => 'paypal',
                    'status' => 'completed',
                ]);

                return redirect()->route('success')->with('success', 'Payment successful!');
            } else {
                \Log::error('Payment not completed. PayPal response:', ['response' => json_encode($response)]);
                return redirect()->route('checkout')->with('error', 'Payment not completed.');
            }
        } catch (\Exception $e) {
            \Log::error('Payment capture failed.', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'Payment capture failed. Please try again.');
        }
    }
}
