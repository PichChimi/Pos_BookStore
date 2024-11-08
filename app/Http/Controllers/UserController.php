<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index(){
        $user = User::get();
        $role = Role::get();
        return view('pages.user',[
            'roles' => $role,
            'users' => $user
        ]);
    }

    
    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
        'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle file upload if profile image is uploaded
    if ($request->hasFile('profile')) {
        $profilePath = $request->file('profile')->store('profiles', 'public');
    }

    // Create the new user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => $request->role_id,
        'profile' => $profilePath ?? null, // Save profile path if uploaded
    ]);

    return response()->json(['success' => 'User created successfully!']);
}

public function update(Request $request, $id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id, // Ignore this user's email
        'password' => 'nullable|string|min:8',
        'role_id' => 'required|exists:roles,id',
        'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle file upload if profile image is uploaded
    if ($request->hasFile('profile')) {
        $profilePath = $request->file('profile')->store('profiles', 'public');
        $user->profile = $profilePath; // Update profile path
    }

    // Update the user's information
    $user->name = $request->name;
    $user->email = $request->email;
    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }
    $user->role_id = $request->role_id;

    $user->save(); // Save the updates

    return response()->json(['success' => 'User updated successfully!']);
}

public function edit($id)
{
    // Find the user by ID and return the data
    $user = User::findOrFail($id);

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role_id' => $user->role_id,
        'profile' => $user->profile,
    ]);
}

public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        // Find the record by its ID
        $role = User::find($request->id);
        $role->delete();

    }

    public function deleteSelected(Request $request)
        {
            $roleIds = $request->input('ids'); // Get the selected role IDs

            if (!empty($roleIds)) {
                User::whereIn('id', $roleIds)->delete(); // Delete roles with the selected IDs
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'No roles selected.'], 400);
            }
        }

}
