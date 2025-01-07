<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Userr;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Point to your login view
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        $user = Userr::where('email', $request->email)->first();
    
        if ($user && Hash::check($request->password, $user->password)) {
    
            if ($user->role == 1) {
                session(['user' => $user]);
    
                return redirect()->route('admin.dashboard');
            } else {
                return back()->withErrors(['email' => 'You do not have access to this page.']);
            }
        } else {
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }
    

    public function dashboard()
    {
       
        $user = session('user');
      
        if (!$user) {
            return redirect()->route('admin.login');
        }


        $users = Userr::paginate(5);
        $products = Product::orderBy('id', 'desc')->paginate(5);


        $userData = Userr::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $productData = DB::table('product')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $orderData = DB::table('order_items')
            ->join('product', 'order_items.pid', '=', 'product.id')
            ->selectRaw('product.name, COUNT(order_items.id) as count')  // Count the order_items.id
            ->groupBy('order_items.pid', 'product.name')
            ->get();

        $labels = [];
        $userCounts = [];
        $productCounts = [];


        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1));
            $userCounts[] = $userData[$i] ?? 0;
            $productCounts[] = $productData[$i] ?? 0;
        }

        foreach ($orderData as $status => $count) {
            $orderStatuses[] = ucfirst($status); // Convert status to a readable format
            $orderCounts[] = $count;
        }



        $totalOrders = DB::table('orders')->count();
        $totalProducts = DB::table('product')->count();
        $totalCustomers = DB::table('user')->where('role', 2)->count();
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'labels',
            'userCounts',
            'productCounts',
            'orderData',
            'users',
            'products',
            'user'
        ));

    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('admin.login');
    }


    public function showProfile()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Return the view with the user data
        return view('admin.profile', compact('user'));
    }

    public function edit($id)
    {
      
        $user = Userr::findOrFail($id);
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'age' => 'required|integer|min:18',
            'gender' => 'required|in:male,female,other',
            'mobile' => 'required|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Find the user
        $user = Userr::findOrFail($id);

        // Update user fields
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->age = $request->input('age');
        $user->gender = $request->input('gender');
        $user->mobile = $request->input('mobile');

        // Check if profile picture is uploaded and update
        if ($request->hasFile('profile_picture')) {
            // Store the new image
            $path = $request->file('profile_picture')->store('uploads', 'public');
            $user->profile_picture = $path;
        }
        // Save the updated user
        $user->save();

        // Redirect back with a success message
        return redirect()->route('admin.profile')->with('success', 'User updated successfully');
    }

}
