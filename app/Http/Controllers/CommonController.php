<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Supports;
use Session;


class CommonController extends Controller
{
    public function updatePasssword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|required_with:password|same:password'
        ]);

        $user = auth()->user();
        if (Hash::check($request->old_password, auth()->user()->password)) {

            if (!Hash::check($request->newpassword, auth()->user()->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
                session()->flash('success', 'password updated successfully');
                return back();
            } else {
                session()->flash('error', 'new password can not be the old password!');
                return back();
            }
        } else {
            session()->flash('success', 'old password doesnt matched ');
            return back();
        }
    }


    public function SupportStore(Request $request)
    {
        // dd($request->all());
        $banned = array("Whore", "Hoe", "Slut", "Bitch", "Retarded", "Prostitut", "Wetback", "Nigga", "Nigger", "Niger", "Nigg", "Blackface", "Coon", "Fuk", "Fuck", "Democrat", "Republican", "Pussy", "Dick", "Vagina", "Penis", "Lesbian", "Gay", "Sex", "Gender", "Dumb", "Stupid");
        $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'last_name' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'email' => ['required', 'email', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'reason' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'message' => ['required', 'string', 'not_regex:/(' . implode("|", $banned) . ')/i'],

            ]);

        $contact = new Supports;
        $contact->user_id = auth()->user()->id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->first_name;
        $contact->email = $request->email;
        $contact->reason = $request->reason;
        $contact->message = $request->message;
        $contact->save();

        // // info@theahap.com 
        // \Mail::to('adminsingh@yopmail.com')->send(new ContactMessage($contact));

        session()->flash('success', 'Support added successfully');
        return back();
    }
}
