<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    //
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'nullable'
            
        ]);
        $emailExists = User::where('email', $request->email)->exists();
        if($emailExists) {
            return [
                'message' => 'Email already exists'
            ];
        }
        $userExists = User::where('name', $request->name)->exists();
        if($userExists) {
            return [
                'message' => 'User already exists'
            ];
        }
        $newUser = User::create($data);
        return [
            'message' => "User created successfully",
        ];
        // return view('users.create');
    }

    // get user
    public function show()
    {
        // return view('users.show', ['user' => $user]);
        return [
            'user' => auth()->user()
        ];
    }

    // update user
    public function updatePassword(Request $request)
    {
        // $user = auth()->user();
        $data = $request->validate([
            // 'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'new_password' => 'required',
            
        ]);
        $user = User::where('email', request('email'))->first();
        if (!$user) {
            return response()->json(['message' => 'The provided credentials do not match our records.'], 404);
        }
        if(Hash::check(request('password'), $user->getAuthPassword())) {
            $user->password = Hash::make(request('new_password'));
            $user->save();
            return [
                'message' => 'Password updated successfully'
            ];
        }
        else {
            return [
                'message' => 'The provided credentials do not match our records.'
            ];
        }
        // $user->update($data);
        // return redirect(route('user.index'))->with('success', 'User updated successfully');
    }
    

    // delete user
    public function destroy(User $user)
    {
        if (Gate::denies('delete-user', $user)) {
            return response()->json(['message' => 'You are not authorized to delete this user'], 403);
        }
        $user->delete();
        return [
            'message' => 'User deleted successfully'
        ];
        // return redirect(route('user.index'))->with('success', 'User deleted successfully');
    }

    public function createAdmin() {
        
    }

    public function updateUser(Request $request) {
        // if (Gate::denies('update-user', $user)) {
        //     return response()->json(['message' => 'You are not authorized to update this user'], 403);
        // }
        $data = $request->validate([
            'name' => 'nullable',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable',
            'role' => 'nullable'
        ]);
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($user instanceof User) {
            $user->update($data);
        } else {
            // Handle the case when $user is not an instance of User.
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($user->name !== $request->name) {
            return [
                'message' => 'User updated not successfully'
            ];
        }
        return [
            'message' => 'User updated successfully'
        ];
    }
}
