<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
class HomeController extends Controller
{
    public function index()
    {
        $user = session('user');
        $cartCount = 0;  // Default value if no user is logged in
    
        if ($user) {
            // If user is logged in, get the count of items in the cart
            $cartCount = Cart::where('uid', $user->id)->count();
        }
        
        $products = Product::all();
        return view('home', compact('products','cartCount'));
    }
}
