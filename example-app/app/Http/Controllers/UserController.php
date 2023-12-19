<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            
        ]);
        $emailExists = User::where('email', $request->email)->exists();
        if($emailExists) {
            return [
                'message' => 'Email already exists'
            ];
        }
        $newUser = User::create($data);
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
    public function update(Request $request)
    {
        // $user = auth()->user();
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'new_password' => 'required',
            
        ]);
        $user = User::where('email', request('email'))->first();
        if(Hash::check(request('password'), $user->getAuthPassword())) {
            $user->password = Hash::make(request('new_password'));
            $user->save();
        }
        // $user->update($data);
        // return redirect(route('user.index'))->with('success', 'User updated successfully');
    }

    // delete user
    public function destroy(User $user)
    {
        $user->delete();
        // return redirect(route('user.index'))->with('success', 'User deleted successfully');
    }
}
