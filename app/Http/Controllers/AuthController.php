<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $token = $user->createToken('authtoken');
        return response()->json([
            'message'=>'User Registered',
            'data'=> ['token' => $token->plainTextToken, 'user' => $user]
        ]);
    }


    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $token = $request->user()->createToken('authtoken');
        return response()->json([
            'message'=>'Login Success',
            'data'=> [
                'user'=> $request->user(),
                'token'=> $token->plainTextToken
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}
