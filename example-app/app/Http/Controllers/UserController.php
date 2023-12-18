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
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            
        ]);
        $user->update($data);
        // return redirect(route('user.index'))->with('success', 'User updated successfully');
    }

    // delete user
    public function destroy(User $user)
    {
        $user->delete();
        // return redirect(route('user.index'))->with('success', 'User deleted successfully');
    }
}
