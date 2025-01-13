<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Userr;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $search = $request->input('search');

        $orderItems = OrderItem::with(['order', 'product'])
            ->when($search, function ($query, $search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })->orWhere('price', 'like', '%' . $search . '%')
                    ->orWhere('order_id', 'like', '%' . $search . '%');
            })
            ->orderBy('order_id', 'desc') // Sorting by the `created_at` field in descending order
            ->paginate(5);

        return view('orders.index', compact('orderItems', 'user'));
    }



    public function show($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('orders.show', compact('order', 'user'));
    }
    public function destroy($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'User deleted successfully');
    }


    public function create()
    {
        $customers = Userr::all();
        $products = Product::all();

        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uid' => 'required|exists:user,id',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'exists:product,id',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'integer|min:1',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'address_line_1' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string',
            'state' => 'required|string',
            'total' => 'required|numeric|min:1',
        ]);

        // Fetch user data based on the uid
        $user = Userr::find($request->uid);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        \DB::beginTransaction();

        try {
            // Create the order using user details
            $order = Order::create([
                'uid' => $request->uid,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'address_line_1' => $request->address_line_1,
                'zip_code' => $request->zip_code,
                'city' => $request->city,
                'state' => $request->state,
                'total' => $request->total,
            ]);

            // Process the order items
            foreach ($request->product_id as $index => $productId) {
                $product = Product::findOrFail($productId);
                $quantity = $request->quantity[$index];
                $price = $product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'pid' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);
            }

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Order created successfully.']);
        } catch (\Exception $e) {
            \DB::rollBack();

            // Log the exception message
            \Log::error('Order creation error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the order. Please try again later.',
                'error' => $e->getMessage(),
            ]);
        }
    }



    public function edit($id)
    {
        // Get the order by ID
        $order = Order::findOrFail($id);
        $customers = Userr::all();
        $products = Product::all();
        $order = Order::with('orderItems.product')->find($id);
        $orderItem = $order->orderItems->first();
        return view('orders.edit', compact('order', 'customers', 'products', 'orderItem'));
    }
    public function update(Request $request, $orderId)
    {
        dd($request->all());
        // Validate the request
        $request->validate([
            'uid' => 'required|exists:user,id',
            'email' => 'required|email',
            'mobile' => 'required|regex:/^[0-9]{10}$/',
            'address_line_1' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'products' => 'required|array',  
            'products.*.pid' => 'required|exists:product,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
    
        $order = Order::findOrFail($orderId);
    
        $order->update([
            'uid' => $request->uid,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address_line_1' => $request->address_line_1,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'state' => $request->state,
        ]);
    
        $products = [];
        foreach ($request->products as $product) {
            if (isset($products[$product['pid']])) {
                $products[$product['pid']] += $product['quantity'];
            } else {
                $products[$product['pid']] = $product['quantity'];
            }
        }
    
        foreach ($products as $productId => $quantity) {
            OrderItem::updateOrCreate(
                ['order_id' => $orderId, 'pid' => $productId],
                ['quantity' => $quantity]
            );
        }
    
        $totalPrice = 0;
        foreach ($order->orderItems as $item) {
            $product = Product::find($item->pid); 
            $totalPrice += $product->price * $item->quantity;
        }
        $order->total = $totalPrice;
        $order->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
        ]);
    }
    
    





}

