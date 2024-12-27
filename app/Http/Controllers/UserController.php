<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $fields = $request->validate([
            'username' => ['max:255'],
            'name' => ['required', 'max:255'],
            'address' => ['nullable', 'max:255'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:3072'],
            'status' => ['required', 'integer', 'in:0,1'],
            'role' => ['required'],
        ]);

        $fields['username'] = strtolower(str_replace(' ', '_', $request->username));
        if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        $fields['password'] = bcrypt($fields['password']);
        //dd($fields);
        User::create($fields);
        return redirect()->route('admin.adduser')->with('greet', 'User successfully added!');
    }
    public function edit($id){
        return redirect()->route('admin.edituser', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        // Base validation rules
        $validationRules = [
            'username' => 'string|max:255',
            'avatar' => $request->hasFile('avatar') ? 'nullable|image|mimes:jpeg,png,jpg|max:3072' : 'nullable', // Only validate if file is uploaded
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20', // Adjust validation as needed
            'status' => 'required|integer',
            'role' => 'required|integer',
        ];
        // Add password validation only if the field is filled
        if ($request->filled('password')) {
            $validationRules['password'] = 'min:8';
        }

        $request->validate($validationRules);

        $user = User::findOrFail($id);

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->address = $request->input('address');
        $user->mobile = $request->input('mobile');
        $user->status = $request->input('status');
        $user->role = $request->input('role');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.viewuser')->with('greet', 'User successfully updated!');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.viewuser')->with('greet', 'User successfully deleted!');
    }

    public function getAgents(){
        $agents = User::all();
        return response()->json($agents);
    }
}
