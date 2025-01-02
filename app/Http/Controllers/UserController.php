<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function showProfile()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('login');
        }
        $cartCount = 0;

        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }

        // Return the view with the user data
        return view('user.profile', compact('user', 'cartCount'));
    }

    public function editProfile(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|digits:10',
            'age' => 'nullable|integer|min:18',
            'gender' => 'required|string',
        ]);

        // Get the authenticated user
        $user = session('user');
        if (!$user) {
            return redirect()->route('login');
        }
        $cartCount = 0;

        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }

        // Update the user's information
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
        ]);

        // Redirect back with a success message
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }


    
    public function fetchOrders()
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('login');
        }
        $cartCount = 0;

        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }
      
        $orders = Order::where('uid', $user->id)
        ->with('orderItems.product')
        ->get();

        return response()->json(['orders' => $orders]);
    }

    public function changePassword(Request $request)
    {
        $user = session('user');
        
        $cartCount = 0;
        
        if ($user) {
            $cartCount = Cart::where('uid', $user->id)->count();
        }
    
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
    
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Current password is incorrect.'
            ]);
        }
    
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Password changed successfully.'
        ]);
    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
