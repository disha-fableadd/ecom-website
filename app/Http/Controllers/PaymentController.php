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
            'payment' => 'required|in:paypal,stripe',
        ]);

        $userId = $user->id;
        $cartItems = Cart::with('product')->where('uid', $userId)->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        DB::beginTransaction();
        try {
            // Create order
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

            // Save order items
            foreach ($cartItems as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->pid = $item->pid;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $item->product->price;
                $orderItem->save();
            }

            DB::commit();

            // Payment handling based on selected method
            $paymentMethod = $request->payment;
            if ($paymentMethod == 'paypal') {
                return $this->processPayPalPayment($order, $total);
            } elseif ($paymentMethod == 'stripe') {
                return $this->processStripePayment($order, $cartItems, $total);
            }
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order creation failed.', ['error' => $e->getMessage()]);
        }
    }

    // Process PayPal Payment
    protected function processPayPalPayment(Order $order, $total)
    {
        // PayPal processing code
        $provider = new \Srmklive\PayPal\Services\PayPal;
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
                    return redirect()->away($link['href']);
                }
            }
        }
    }

    // Process Stripe Payment
    protected function processStripePayment(Order $order, $cartItems, $total)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $redirectUrl = route('success') . '?session_id={CHECKOUT_SESSION_ID}';
    
            
            $response = $stripe->checkout->sessions->create([
                'success_url' => $redirectUrl,
                'cancel_url' => route('checkout'),
                'payment_method_types' => ['card'],
                'line_items' => collect($cartItems)->map(function ($item) {
                    return [
                        'price_data' => [
                            'product_data' => [
                                'name' => $item->product->name,
                            ],
                            'unit_amount' => $item->product->price * 100,
                            'currency' => 'usd',
                        ],
                        'quantity' => $item->quantity,
                    ];
                })->toArray(),
                'mode' => 'payment',
                'allow_promotion_codes' => true,
            ]);
    
            \Log::info('Stripe session created:', ['session' => $response]);
    
            if (isset($response['url'])) {
              
                Cart::where('uid', $order->uid)->delete();
    
                Transaction::create([
                    'order_id' => $order->id,
                    'payment_method' => 'stripe',
                    'status' => 'complete', 
                ]);
    
                return redirect($response['url']);
            } else {
                \Log::error('Stripe session URL missing:', ['session' => $response]);
                return redirect()->route('checkout')->with('error', 'There was an error creating the payment session.');
            }
        } catch (\Exception $e) {
            \Log::error('Stripe session creation failed.', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'An error occurred while creating the payment session.');
        }
    }
    

    // Capture Payment (both PayPal and Stripe)
    public function capturePayment(Request $request)
    {
        if ($request->has('session_id')) {
            return $this->captureStripePayment($request);
        } elseif ($request->has('token')) {
            return $this->capturePayPalPayment($request);
        }
    }

    // Capture PayPal Payment
    protected function capturePayPalPayment(Request $request)
    {
        $provider = new \Srmklive\PayPal\Services\PayPal;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $response = $provider->capturePaymentOrder($request->query('token'));

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
            }

        } catch (\Exception $e) {
            \Log::error('PayPal payment capture failed.', ['error' => $e->getMessage()]);
        }
    }

    // Capture Stripe Payment
    protected function captureStripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $session = $stripe->checkout->sessions->retrieve($request->session_id);

            \Log::info('Stripe session retrieved:', ['session' => $session]);

            if ($session && $session->payment_status == 'paid') {
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
                    'payment_method' => 'stripe',
                    'status' => 'completed',
                ]);

                return redirect()->route('success')->with('success', 'Payment successful!');
            } else {
                \Log::error('Stripe payment not completed or failed:', ['session' => $session]);
                return redirect()->route('checkout')->with('error', 'Payment was not completed.');
            }
        } catch (\Exception $e) {
            \Log::error('Stripe payment capture failed.', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'An error occurred while processing the payment.');
        }
    }

}
