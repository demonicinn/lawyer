<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;


class CommonController extends Controller
{
    public function updatePasssword(Request $request)
    {
        $request->validate([

            'password' => 'required',
            'password_confirmation' => 'required|required_with:password|same:password'
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

      
        Session::flash('success', 'Password updated successfully');
        return redirect()->back();
    }
}
