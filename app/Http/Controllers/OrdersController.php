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

  }
