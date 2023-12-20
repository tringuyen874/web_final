<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login() {
        validator(request()->only('email', 'password'), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();

        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return [
            'access_token' => $token,
            'token_type' => 'Bearer'
        ];

        // $user = User::where('email', request('email'))->first();

        // if(Hash::check(request('password'), $user->getAuthPassword())) {
        //     $token = $user->createToken('auth_token')->plainTextToken;
        //     // return response()->json([
        //     //     'access_token' => $token,
        //     //     // 'token_type' => 'Bearer'
        //     // ]);
        //     return [
        //         'access_token' => $token,
        //         // 'token_type' => 'Bearer'
        //     ];
        // }
        // else {
        //     return [
        //         'message' => 'The provided credentials do not match our records.'
        //     ];
        // }
    }

    public function logout() {
        auth()->user()->currentAccessToken()->delete();
        // return response()->json(['message' => 'Tokens Revoked']);
        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
