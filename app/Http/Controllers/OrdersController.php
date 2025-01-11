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
            ->orderBy('created_at', 'desc') // Sorting by the `created_at` field in descending order
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
        $request->validate([
            'uid' => 'required|exists:user,id',
            'product_id' => 'required|exists:product,id',
            'quantity' => 'required|numeric|min:1',
            'email' => 'required|email',
            'mobile' => 'required',
            'address_line_1' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
    
        $user = Userr::find($request->uid);
        $product = Product::find($request->product_id);
        $total = $product->price * $request->quantity;
    
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
            'total' => $total,
        ]);
    
        OrderItem::create([
            'order_id' => $order->id,
            'pid' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'order added successfully!',
                'order' => $order, 
            ]);
        }
    
        return redirect()->route('orders.index')->with('success', 'user added successfully.'); 
       }
    

    public function edit($id)
    {
        // Retrieve the order by its ID
        $order = Order::findOrFail($id);

        // Retrieve all customers and products
        $customers = Userr::all();
        $products = Product::all();



        $order = Order::with('orderItems.product')->find($id);
        $orderItem = $order->orderItems->first();

        return view('orders.edit', compact('order', 'customers', 'products', 'orderItem'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
    
        $validatedData = $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'address_line_1' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
        ]);
    
        $orderItem = $order->orderItems->first();
    
        if (!$orderItem) {
            return back()->withErrors(['error' => 'No order items found for this order']);
        }
    
        $totalPrice = $validatedData['quantity'] * $orderItem->product->price;
    
        $orderItem->update([
            'quantity' => $validatedData['quantity'],
        ]);
    
        $order->update([
            'total' => $totalPrice,
            'address_line_1' => $validatedData['address_line_1'],
            'zip_code' => $validatedData['zip_code'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            // Add any other fields you want to update
        ]);
    
        return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
    }
    
}
