<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function login() {
        validator(request()->only('email', 'password'), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();
        $user = User::where('email', request('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'The provided credentials do not match our records.'], 404);
        }
        if (Hash::check(request('password'), $user->getAuthPassword())){
            $credentials = request(['email', 'password']);

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return [
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];
        }
        else {
            
            return response()->json(['message' => 'The provided credentials do not match our records.'], 404);
            
        }
        

        

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

    public function createAdmin(User $user) {
        if (Gate::denies('create-admin', $user)) {
            return response()->json(['message' => 'You are not authorized to delete this user'], 403);
        }
        // $admin = auth()->user();
        // if ($admin->role !== 'admin') {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }
        $user->role = 'admin';
        $user->save();
        return [
            'message' => 'User role updated to admin'
        ];
    }

    // public function logout() {
    //     auth()->user()->currentAccessToken()->delete();
    //     // return response()->json(['message' => 'Tokens Revoked']);
    //     return [
    //         'message' => 'Tokens Revoked'
    //     ];
    // }

    public function sendMail(Request $request) {
        $otp = rand(100000, 999999);
        $email = $request->email;
        // $user = User::where('email', $email)->first();
        // $user->otp = $otp;
        // $user->save();
        // $details = [
        //     'title' => 'OTP to update password',
        //     'otp' => $otp,
        //     'userEmails' => $email
        // ];
        Mail::send(new \App\Mail\SendMail($otp, $email));
        return [
            'message' => 'OTP sent to your email',
            'otp' => $otp
        ];
    }

    public function adminLogin() {
        validator(request()->only('email', 'password'), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ])->validate();
        $user = User::where('email', request('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'The provided credentials do not match our records.'], 404);
        }
        if (Hash::check(request('password'), $user->getAuthPassword()) ){
            $credentials = request(['email', 'password']);

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if ($user->role !== 'admin') {
                return response()->json(['message' => 'You are not authorized to login as admin'], 403);
            }
            return [
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];
        }
        else {
            
            return response()->json(['message' => 'The provided credentials do not match our records.'], 404);
            
        }
    }
}
