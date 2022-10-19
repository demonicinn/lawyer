<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SupportNotification;
use App\Notifications\ResponseToLawyerRequest;
use App\Notifications\RescheduleMail;
use Illuminate\Support\Facades\Notification;
use App\Models\Supports;
use App\Models\User;
use App\Models\Category;
use App\Models\Note;
use App\Models\Payment;
use App\Notifications\LawyerMailForCaseStatus;
use App\Notifications\MailToAdminForLawyerStatus;
use App\Notifications\UserMailForCaseStatus;
use App\Notifications\CaseAcceptReviewNotification;
use Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Stripe\Charge;


use App\Http\Controllers\MeetingController;



class CommonController extends Controller
{
    use LivewireAlert;

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
                $this->flash('success', 'password updated successfully');

                return back();
            } else {
                $this->flash('error', 'new password can not be the old password!');;
                return back();
            }
        } else {
            $this->flash('success', 'old password doesnt matched ');

            return back();
        }
    }


    public function SupportStore(Request $request)
    {
        
        $banned = array("Whore", "Hoe", "Slut", "Bitch", "Retarded", "Prostitut", "Wetback", "Nigga", "Nigger", "Niger", "Nigg", "Blackface", "Coon", "Fuk", "Fuck", "Democrat", "Republican", "Pussy", "Dick", "Vagina", "Penis", "Lesbian", "Gay", "Sex", "Gender", "Dumb", "Stupid");
        $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'last_name' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'email' => ['required', 'email', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'reason' => ['required', 'string', 'max:255', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                'message' => ['required', 'string', 'not_regex:/(' . implode("|", $banned) . ')/i'],
                //'g-recaptcha-response' => 'recaptcha|required',

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

        //Notification::route('mail', env('ADMIN_EMAIL'))->notify(new SupportNotification($contact));
        Notification::route('mail', 'info.gurpreetsaini@gmail.com')->notify(new SupportNotification($contact));

        //dd($request->all());

        $this->flash('success', 'Support added successfully pp');
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
        })->with('lawyerInfo', function ($query) {
            $query->with('categories', 'items');
        })->with('lawyerLitigations', function ($query) {
            $query->with('litigation');
        })->with('lawyerContracts', function ($query) {
            $query->with('contract');
        })->first();

    
        $categories = Category::with('items')->get();



        return view('admin.lawyers.view-details', compact('title', 'user', 'categories'));
    }

    public function viewUserDetails($id)
    {
        $title = array(
            'title' => 'View Client Details',
            'active' => 'client',
        );
        $user = User::where('id', $id)->first();
        return view('admin.users.view-details', compact('title', 'user'));
    }


    public function blockLawyer(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $user->status = '2';
        $user->save();
        $action = "blocked";

        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        $this->flash('success', 'Lawyer block successfully');
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
        $this->flash('success', 'Lawyer de-active  successfully');
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
        $this->flash('success', 'Lawyer accept successfully');
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
        $this->flash('success', 'Lawyer declined successfully');
        return back();
    }

    public function consultations()
    {
        $title = array(
            'title' => 'Consultations',
            'active' => 'upcoming',
        );

        $authUser = auth()->user();


        $upcomingConsultations = Booking::query();

            if ($authUser->role == 'lawyer') {
                $upcomingConsultations = $upcomingConsultations->where('lawyer_id', $authUser->id);
            }
            else {
                $upcomingConsultations = $upcomingConsultations->where('user_id', $authUser->id);
            }

            $upcomingConsultations = $upcomingConsultations->where('booking_Date', '>=', date('Y-m-d'))
                ->where('is_call', 'pending')
                ->where('reschedule', '0')
                ->where('is_canceled', '0')
                ->with('lawyer')->latest('id')->get();



        return view('pages.consultations.upcoming', compact('title', 'upcomingConsultations'));
    }

    public function completeConsultations()
    {
        $title = array(
            'title' => 'Consultations',
            'active' => 'complete',
        );
        $authUser = auth()->user();

        if ($authUser->role == 'lawyer') {
            $completeConsultations = Booking::where('lawyer_id', $authUser->id)
                ->where('is_call', 'completed')
                ->where('is_accepted', '0')
                ->where('is_canceled', '0')
                ->with('user', 'notes')->latest('id')->get();
            //   dd( $completeConsultations);
        } else {

            $completeConsultations = Booking::where('user_id', $authUser->id)
                ->where('is_call', 'completed')
                ->where('is_accepted', '0')
                ->where('is_canceled', '0')
                ->with('lawyer')->latest('id')->get();
        }
        return view('pages.consultations.completed', compact('title', 'completeConsultations'));
    }

    public function acceptedConsultations()
    {
        $title = array(
            'title' => 'Consultations',
            'active' => 'accepted',
        );
        $authUser = auth()->user();

        if ($authUser->role == 'lawyer') {
            $accptedConsultations = Booking::where('lawyer_id', $authUser->id)
                ->where('is_call', 'completed')
                ->where('is_accepted', '1')
                ->where('is_canceled', '0')
                ->with('user', 'notes')->latest('id')->get();
            // dd($accptedConsultations);
        } else {

            $accptedConsultations = Booking::where('user_id', $authUser->id)
                ->where('is_call', 'completed')
                ->where('is_accepted', '1')
                ->where('is_canceled', '0')
                ->with('lawyer', 'notes')->latest('id')->get();
        }


        return view('pages.consultations.accepted', compact('title', 'accptedConsultations'));
    }


    public function resheduleConsultations($id)
    {

        //dd("rechdule by admin");
        $booking = Booking::where('id', $id)->with('user', 'lawyer')->first();
        $booking->reschedule = '1';
        $booking->update();


        if ($booking) {
            if (auth()->user()->role == 'user') {
                //send reschedule mail to lawyer
                $lawyerInfo = $booking->lawyer;
                Notification::route('mail', $booking->lawyer->email)->notify(new RescheduleMail($booking, $lawyerInfo));
            } else {

                //send reschedule mail to user
                $userInfo = $booking->user;
                Notification::route('mail', $userInfo->email)->notify(new RescheduleMail($booking, $userInfo));
            }
            $this->flash('success', 'Reschedule done successfully');
            return back();
        }
    }

    public function addNote(Request $request, $id)
    {
        $request->validate([
            'note' => 'required',
        ]);
        $saveNote = new Note;
        $saveNote->note = $request->note;
        $saveNote->booking_id = $id;
        $saveNote->user_id = auth()->user()->id;
        $saveNote->save();
        $this->flash('success', 'Note added successfully');
        return back();
    }

    public function editNote(Request $request, $id)
    {

        $updateNote = Note::where('id', $id)->first();
        $updateNote->note = $request->note;
        $updateNote->update();
        $this->flash('success', 'Note updated successfully');
        return back();
    }


    public function acceptCase($id)
    {
        $acceptCase = Booking::where('id', $id)->with('cardDetails')->first();
        $acceptCase->is_call = "completed";
        $acceptCase->is_accepted = '1';
        $acceptCase->update();

        // dd($acceptCase->cardDetails->customer_id);
        if ($acceptCase) {
            
            $status = 'accepted';
            $authUser = auth()->user();

            // send mail to user
            Notification::route('mail', $acceptCase->user_email)->notify(new UserMailForCaseStatus($acceptCase, $status));

            Notification::route('mail', $acceptCase->user_email)->notify(new CaseAcceptReviewNotification($acceptCase, $authUser));

            // send mail to lawyer
            //Notification::route('mail', $authUser->email)->notify(new LawyerMailForCaseStatus($acceptCase, $status));
            
            return redirect()->route('consultations.accepted');
            
        }
    }

    public function declineCase($id)
    {
        $declineCase = Booking::where('id', $id)->first();
        $declineCase->is_call = "completed";
        $declineCase->is_accepted = '2';
        $declineCase->update();

        if ($declineCase) {
            $status = 'declined';

            $authUser = auth()->user();

            Notification::route('mail', $declineCase->user_email)->notify(new UserMailForCaseStatus($declineCase, $status));

            Notification::route('mail', $declineCase->user_email)->notify(new CaseAcceptReviewNotification($declineCase, $authUser));


            Notification::route('mail', $authUser->email)->notify(new LawyerMailForCaseStatus($declineCase, $status));


            $this->flash('success', 'Case declined successfully');
        } else {
            $this->flash('error', 'Something went wrong');
        }
        return back();
        return redirect()->route('consultations.accepted');
    }

    public function reschedule($id)
   {

       $bookingId=$id;
        $title = array(
            'title' => 'Schedule a Consultation',
            'active' => 'reschedule-consultation',
        );

        $user = auth()->user();

        return view('pages.reschedule', compact('bookingId'));
    }



    public function adminTransactions()
    {
        $title = array(
            'title' => 'Transactions',
            'active' => 'transactions',
        );

        $transactions = Payment::paginate(10);

        return view('admin.transactions.index', compact('title', 'transactions'));
    }



    public function thankYou()
    {
        $title = array(
            'title' => 'Thank You',
            'active' => 'thankYou',
        );

        return view('pages.thankYou', compact('title'));
    }


    public function consultationsCancel(Request $request)
    {
        $user = auth()->user();

        $booking = Booking::where('id', $request->id)->where('user_id', $user->id)->first();

        if(!$booking){
            abort(404);
        }

        $meeting = new MeetingController;
        $a = $meeting->destroy($booking);

        ///
        if($a){
            $booking->is_canceled = '1';
            $booking->save();

            $this->flash('success', 'Booking Canceled');

        }
        $this->flash('error', 'Something went wrong');
    }




    
}
