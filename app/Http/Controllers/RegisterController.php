<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
{
    // Validate input data
    $validator = Validator::make($request->all(), [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|unique:user,email',
        'password' => 'required|min:6',
        'age' => 'required|integer|min:18',
        'gender' => 'required',
        'mobile' => 'required|digits:10',
        'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    $profile_picture = $request->file('profile_picture');
    
    $profile_picture_path = $profile_picture->store('uploads', 'public'); 

    Userr::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'age' => $request->age,
        'gender' => $request->gender,
        'mobile' => $request->mobile,
        'profile_picture' => $profile_picture_path,
    ]);

    return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
}
}
