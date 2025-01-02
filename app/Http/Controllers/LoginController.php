<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Userr;

class LoginController extends Controller
{
    public function create()
    {
        return view('login'); 
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        
        $user = Userr::where('email', $request->email)->first();

       
        if ($user && Hash::check($request->password, $user->password)) {
            
            session(['user' => $user]);
            
            return redirect()->route('home');
        } else {
         
            return back()->withErrors(['email' => 'Invalid email or password.']);
        }
    }
    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
