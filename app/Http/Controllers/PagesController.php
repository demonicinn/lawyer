<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Litigation;
use App\Models\Contract;
use App\Models\SavedLawyer;
use App\Models\User;
use App\Models\JoinTeam;
use Illuminate\Support\Facades\Crypt;
use Jantinnerezo\LivewireAlert\LivewireAlert;


use Illuminate\Support\Facades\Notification;
use App\Notifications\JoinTeamNotification;
use Carbon\Carbon;

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
        
        
        if($request->type == 'litigation'){
            $request->validate([
                'litigations' => 'required'
            ],
            [
                //'litigations.required' => 'required'
            ]);
        }
        else {
            $request->validate([
                'contracts' => 'required'
            ]);
        }
        
        
        $route = "narrow.litigations";
        if (@$request->contracts) {
            $route = "narrow.contracts";
        }
        return view('pages.lawyers', compact('route'));
    }

    //
    public function lawyerShow(Request $request)
    {
        
        $user = User::with(['lawyerReviews', 'booking', 'details'])->where('id', $request->user)->first();
        
        
        $date = date('Y-m-d');
        $date3Months = Carbon::parse($date)->subtract(3, 'months')->format('Y-m-d');
        
        if (@$user->status == '1' && @$user->details->is_verified == 'yes') {
            
            
            
            $totalCount = $user->lawyerReviews()->count();
            $totalRating = $user->lawyerReviews()->sum('rating');
            
            if($totalCount > 0){
                $overAllRating = $totalRating / $totalCount;
                
                
                $countCancleBookings = $user->booking()->where('is_canceled', '1')->where('booking_date', '>=', $date3Months)->count();
                
                $checkRating = 0;
                if($countCancleBookings > '0' && $countCancleBookings <= '2'){
                    $checkRating = 0.5;
                }
                if($countCancleBookings >= '3' && $countCancleBookings <= '9'){
                    $checkRating = 1;
                }
                if($countCancleBookings >= '10'){
                    $checkRating = 2;
                }
            
                $newRating = $overAllRating - $checkRating;
            
                $user->rating = number_format($newRating, 1);
            }
            else {
                $user->rating = '';
            }
            
            
            
            return view('pages.lawyers-show', compact('user'));
        }
        abort(404);
    }

    public function saveLaywer(Request $request, $id)
    {
        $lawyerID = Crypt::decrypt($id);
        $authUser = auth()->user();
        $saveLawyer = new SavedLawyer;
        $saveLawyer->user_id = $authUser->id;
        $saveLawyer->lawyer_id = $lawyerID;
        $saveLawyer->type = $request->type;
        $saveLawyer->data = $request->search;
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



    //
    public function joinTeam()
    {
        $title = array(
            'title' => 'Join the Team',
            'active' => 'joinTeam',
        );

        return view('pages.joinTeam', compact('title'));
    }


    public function joinTeamStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'resume' => 'required|file',
        ]);

        //...

        $store = new JoinTeam;
        $path = 'storage/resume/';
        if ($request->hasFile('resume')){
            if(!is_dir($path)) {
                mkdir($path, 0775, true);
                chown($path, exec('whoami'));
            }

            $file = $request->file('resume');
            $filename = uniqid(time()) . '.' . $file->getClientOriginalExtension();
            $request->file('resume')->move($path, $filename);
            
            //...
            $store->resume = $filename;
        }
        $store->name = $request->name;
        $store->email = $request->email;
        $store->save();
        
        //...
        Notification::route('mail', env('JOIN_TEAM'))->notify(new JoinTeamNotification($store));

        $this->flash('success', "Your resume submitted, We'll update you after review it"); 
        return back();
    }


    public function lawyersHome(Request $request){

        $data = array();

        if(@$request->type=='contract'){
            $data['contracts'][] = $request->search;
        }

        if(@$request->type=='litigation'){
            $data['litigations'][] = $request->search;
        }

        $data['latitude'] = @$request->latitude;
        $data['longitude'] = @$request->longitude;
        $data['type'] = @$request->type;

        return redirect()->route('lawyers', $data);
    }


    public function privacyPolicy()
    {
        $title = array(
            'title' => 'Privacy Policy',
            'active' => 'privacyPolicy',
        );

        return view('pages.privacyPolicy', compact('title'));
    }

    public function termsService()
    {
        $title = array(
            'title' => 'Terms of Service',
            'active' => 'termsService',
        );

        return view('pages.termsService', compact('title'));
    }

    public function faq()
    {
        $title = array(
            'title' => "FAQS",
            'active' => 'faq',
        );

        return view('pages.faq', compact('title'));
    }
    
   public function styleGuide()
    {
        $title = array(
            'title' => "Style Guide",
            'active' => 'styleGuide',
        );

        return view('pages.style-guide', compact('title'));
    }
	
	
	public function lawyerLink()
    {
        $title = array(
            'title' => 'How to add lawyer link',
            'active' => 'how-to-add-lawyer-link',
        );

        return view('pages.lawyer_link', compact('title'));
    }
	
	
	
}
