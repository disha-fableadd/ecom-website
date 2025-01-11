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
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }


        return view('users.create', compact('user'));
    }

    // Store a New User
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:6',
            'age' => 'required|integer',
            'gender' => 'required|in:Male,Female,Other',
            'mobile' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        $profile_picture_path = null;
        if ($request->hasFile('profile_picture')) {
            $profile_picture = $request->file('profile_picture');
            $profile_picture_path = $profile_picture->store('uploads', 'public');
        }
    
        $user = Userr::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'mobile' => $request->mobile,
            'profile_picture' => $profile_picture_path,
        ]);
    
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'customer added successfully!',
                'user' => $user, 
            ]);
        }
        return redirect()->route('users.index')->with('success', 'user added successfully.');    }
    
    // Display All Users
    public function index(Request $request)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $query = Userr::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where('first_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->orderBy('updated_at', 'desc')->paginate(5);

        return view('users.index', compact('users', 'user'));
    }
    public function show($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }
        $userr = Userr::findOrFail($id);

        return view('users.show', compact('userr', 'user'));
    }

    public function edit($id)
    {
        $user = session('user');
        if (!$user) {
            return redirect()->route('admin.login');
        }

        $userr = Userr::findOrFail($id);
        return view('users.edit', compact('userr', 'user'));
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
            'gender' => 'required|in:Male,Female,Other',
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

