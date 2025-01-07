<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userr;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function create()
    {
        return view('users.create');
    }

    // Store a New User
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female,other',
            'mobile' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

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

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }

    // Display All Users
    public function index()
    {
        $users = Userr::paginate(5);
        return view('users.index', compact('users'));
    }
    public function show($id)
    {
        $user = Userr::findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        // dd('Edit route reached'); // Debugging to check if the route is being hit
        $user = Userr::findOrFail($id);
        return view('users.edit', compact('user'));
    }
    public function update(Request $request, $uid)
    {
        $user = Userr::findOrFail($uid);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,',
            'password' => 'nullable|min:8',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'mobile' => 'required|string',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password ? bcrypt($request->password) : $user->password;
        $user->age = $request->age;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;

        // Profile picture upload
        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $imageName);
            $user->profile_picture = $imageName;
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = Userr::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}

