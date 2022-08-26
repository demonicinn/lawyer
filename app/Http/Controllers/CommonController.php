<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SupportNotification;
use App\Notifications\ResponseToLawyerRequest;


use Illuminate\Support\Facades\Notification;
use App\Models\Supports;
use App\Models\User;
use App\Models\Category;


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

            ]
        );

        $contact = new Supports;
        $contact->user_id = auth()->user()->id;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->first_name;
        $contact->email = $request->email;
        $contact->reason = $request->reason;
        $contact->message = $request->message;
        $contact->save();

        Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new SupportNotification($contact));
        session()->flash('success', 'Support added successfully');
        return back();
    }

    public function viewlawyerDetails($id)
    {

        $title = array(
            'title' => 'View Lawyer Details',
            'active' => 'lawyers',
        );

        $user = User::where('id', $id)->with('details', function ($query) {
            $query->with('states');
        })->with('lawyerInfo', function ($query1) {
            $query1->with('categories', 'items');
        })->with('lawyerLitigations', function ($query2) {
            $query2->with('litigations');
        })->with('lawyerContracts', function ($query3) {
            $query3->with('contracts');
        })->first();

        // dd($user );
        $categories = Category::with('items')->get();

        return view('admin.lawyers.view-details', compact('title', 'user', 'categories'));
    }


    public function blockLawyer(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->status = '2';
        $user->save();
        $action = "blocked";

        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        session()->flash('success', 'Lawyer block successfully');
        return back();
    }

    public function deActiveLawyer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = '0';
        $user->save();
        $action = "deactivated";

        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        session()->flash('success', 'Lawyer de-active  successfully');
        return back();
    }

    public function acceptLawyer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->details->is_admin_review = '1';
        $user->details->is_verified = 'yes';
        $user->details->save();
        $action = "accept";
        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        session()->flash('success', 'Lawyer accept successfully');
        return back();
    }
    public function declinedLawyer(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->details->is_admin_review = '2';
        $user->details->review_request = '0';
        $user->details->save();
        $action = "declined";
        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        session()->flash('success', 'Lawyer declined successfully');
        return back();
    }
}
