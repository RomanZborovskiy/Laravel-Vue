<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
         if (!Auth::attempt($request->only(['email', 'password']))) {
        return response()->json([
            'message' => 'Wrong email or password'
        ], 401);
    }

    $user = Auth::user();
    $user->tokens()->delete(); 

    $token = $user->createToken($user->name)->plainTextToken;

    return response()->json([
        'data' => [
            'user' => $user,
            'token' => $token,
        ]
    ]);
    }

    public function logout(Request $request) {
        $user=Auth::user();
        if ($user = $request->user()) {
        $user->tokens()->delete();
        
        return response()->json(['message' => 'Logged out successfully']);
    }
    
    return response()->json(['message' => 'No authenticated user'], 401);
    }
}
