<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {//dd($request);
        // Validate the incoming request data
        $fields = $request->validate([
            'username' => ['max:255'],
            'name' => ['required', 'max:255'],
            'address' => ['nullable', 'max:255'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'avatar' => ['nullable', 'image', 'max:3072'], // Maximum file size: 3MB
            'status' => ['required', 'integer', 'in:0,1'],
            'role' => ['required'], // Status must be Active or Inactive
        ]);
        $fields['username'] = strtolower(str_replace(' ', '_', $request->username));
//dd($fields);
        // Handle file upload for avatar
        if ($request->hasFile('avatar')) {
            $fields['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Encrypt the password before saving
        $fields['password'] = bcrypt($fields['password']);
//dd($fields);
        // Create the user
        User::create($fields);

        // Redirect with a success message
        return redirect()->route('admin.adduser')->with('greet', 'User successfully added!');
    }

}
