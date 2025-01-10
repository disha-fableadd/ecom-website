<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Models\Category;
class ProductController extends Controller
{
    public function show($id)
    {
        $user = session('user');
        $cartCount = 0;  // Default value if no user is logged in
    
        if ($user) {
            // If user is logged in, get the count of items in the cart
            $cartCount = Cart::where('uid', $user->id)->count();
        }

        $products = Product::find($id);

        if (!$products) {
            abort(404); 
        }

        return view('product.show', compact('products','cartCount'));
    }
    public function index(Request $request)
    {
        $user = session('user');
        $cartCount = 0;  // Default value if no user is logged in
    
        if ($user) {
            // If user is logged in, get the count of items in the cart
            $cartCount = Cart::where('uid', $user->id)->count();
        }


        $products_per_page = 6;
        $page = $request->input('page', 1);
        $price_filter = $request->input('price', 'all');
        $search_keyword = $request->input('search', '');
        $sort_option = $request->input('sort', 'all_categories');
       

        $query = Product::query();

       
        if ($price_filter !== 'all') {
       
            $priceRanges = [
                '0-100' => [0, 100],
                '100-200' => [100, 200],
                '200-300' => [200, 300],
                '300-400' => [300, 400],
            ];
    
            if (array_key_exists($price_filter, $priceRanges)) {
                $query->whereBetween('price', $priceRanges[$price_filter]);
            } else {
                return abort(404, 'Invalid price filter');
            }
        }

      
        if ($search_keyword) {
            $query->where('name', 'like', '%' . $search_keyword . '%');
        }

       // Check if sorting by category
       if (str_starts_with($sort_option, 'category_')) {
        $category_id = str_replace('category_', '', $sort_option);
        $query->where('category_id', $category_id);
    }

    if ($sort_option && $sort_option !== 'all_categories') {
        $query->orderBy('id');
    }

    $products = $query->paginate($products_per_page);

    $categories = Category::all();

        return view('product.index', compact('products', 'price_filter', 'search_keyword', 'categories','cartCount', 'sort_option', 'sort_option'));
    }
}
