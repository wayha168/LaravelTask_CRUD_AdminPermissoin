<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return response()->json($request->user());
    }

    public function show(User $profile)
    {
        return response()->json($profile);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed', // expects password_confirmation field
        ]);

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('password')) $user->password = bcrypt($request->password);

        $user->save();

        return response()->json($user);
    }

    public function allUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
}
