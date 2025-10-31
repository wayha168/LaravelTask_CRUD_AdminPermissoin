<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use ApiResponse;

    public function register(StorePostRequest $request)
    {
        $isAdmin = filter_var($request->input('is_admin', false), FILTER_VALIDATE_BOOLEAN);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isAdmin,
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->created([
            'user' => $user,
            'token' => $token,
        ], 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('API Token')->plainTextToken;

            return $this->success([
                'user' => $user,
                'token' => $token,
            ], 'Login successful');
        }

        return $this->error('Invalid credentials', 401);
    }
}
