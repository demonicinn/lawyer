<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Litigation;
use App\Models\Contract;
use App\Models\SavedLawyer;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class PagesController extends Controller
{
    use LivewireAlert;
    //
    public function home()
    {
        $title = array(
            'title' => 'Home',
            'active' => 'home',
        );

        return view('pages.home', compact('title'));
    }


    //
    public function narrowDown()
    {
        $title = array(
            'title' => 'Narrow Down Candidates',
            'active' => 'narrowDown',
        );

        return view('pages.narrowDown', compact('title'));
    }

    //
    public function litigations()
    {
        $title = array(
            'title' => 'Narrow Down Litigations',
            'active' => 'litigations',
        );

        $litigations = Litigation::whereStatus('1')->orderBy('name', 'asc')->get();
        return view('pages.litigations', compact('title', 'litigations'));
    }

    //
    public function contracts()
    {
        $title = array(
            'title' => 'Narrow Down Contracts',
            'active' => 'contracts',
        );
        $contracts = Contract::whereStatus('1')->orderBy('name', 'asc')->get();
        return view('pages.contracts', compact('title', 'contracts'));
    }

    //
    public function lawyers(Request $request)
    {
        $route = "narrow.litigations";
        if (@$request->contracts) {
            $route = "narrow.contracts";
        }
        return view('pages.lawyers', compact('route'));
    }

    //
    public function lawyerShow(Request $request, User $user)
    {
        if (@$user->status == '1' && @$user->details->is_verified == 'yes') {
            return view('pages.lawyers-show', compact('user'));
        }
        abort(404);
    }

    public function saveLaywer($id)
    {
        $lawyerID = Crypt::decrypt($id);
        $authUser = auth()->user();
        $saveLawyer = new SavedLawyer;
        $saveLawyer->user_id = $authUser->id;
        $saveLawyer->lawyer_id = $lawyerID;
        $saveLawyer->save();

        if ($authUser) {
            $this->flash('success', 'Saved Attorney');
            return back();
        }
    }

    public function removeLaywer($id)
    {
        $lawyerID = Crypt::decrypt($id);
        $authUser = auth()->user();

        $checkLawyer = SavedLawyer::where('user_id', $authUser->id)
                        ->where('lawyer_id', $lawyerID)->first();


        if (@$checkLawyer) {
            $checkLawyer->delete();
            $this->flash('success', 'Attorney Removed');            
        }
        else {
            $this->flash('error', 'Server Error');            
        }

        return back();

    }


    public function about()
    {
        $title = array(
            'title' => 'About Us',
            'active' => 'about',
        );

        return view('pages.about', compact('title'));
    }


}
