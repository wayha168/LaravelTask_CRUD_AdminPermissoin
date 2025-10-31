<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\User;
use App\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use ApiResponse;

    public function register(StorePostRequest $request)
    {
        $isAdmin = filter_var($request->input('is_admin', false), FILTER_VALIDATE_BOOLEAN);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $isAdmin,
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->created([
            'user'  => $user,
            'token' => $token,
        ], 'User registered successfully');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('API Token')->plainTextToken;

            return $this->success([
                'user'  => $user,
                'token' => $token,
            ], 'Login successful');
        }

        return $this->error('Invalid credentials', 401);
    }


    // ── WEB: Show Login Form 
    public function showLogin()
    {
        return view('auth.login');
    }

    // ── WEB: Login ───────────────────────
    public function webLogin(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials are incorrect.'
            ])->withInput($request->only('email'));
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
    
    //web logout
    public function webLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function createUser()
    {
        return view('users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'is_admin' => 'sometimes|boolean',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->input('is_admin', false),
        ]);

        return redirect()->route('dashboard')->with('success', 'User created successfully!');
    }
}
