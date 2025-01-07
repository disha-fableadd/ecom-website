<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('orderItems.product')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }
    public function destroy($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'User deleted successfully');
    }
    
}
