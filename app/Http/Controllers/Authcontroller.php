<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Authcontroller extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Error'
            ], 401);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return [new UserResource($user), 'token' => $token];
    }
    public function logout(Request $request)
    {
        // dd($request);
        $request->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();
        // dd($request); 

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
