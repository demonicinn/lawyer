<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfileController extends Controller
{
    use LivewireAlert;
    
    public function index()
    {
        $title = array(
            'title' => 'Update Account Information',
            'active' => 'profile',
        );
        $user = auth()->user();
        return view('user.profile.index', compact('user', 'title'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'contact_number' => 'required|numeric|digits_between:10,12',
        ], [
            'contact_number.required' => 'The phone  field is required.',
        ]);

        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->contact_number = $request->contact_number;
        $user->save();

        $this->flash('success', 'Profile updated successfully');
        return redirect()->back();
    }
}
