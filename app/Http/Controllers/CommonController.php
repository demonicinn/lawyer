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
use App\Models\StateBar;
use App\Models\Note;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\PaymentStatus;
use App\Models\State;
use App\Notifications\LawyerMailForCaseStatus;
use App\Notifications\MailToAdminForLawyerStatus;
use App\Notifications\UserMailForCaseStatus;
use App\Notifications\CaseAcceptReviewNotification;
use App\Notifications\OfferNotification;
use Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Stripe\Charge;
use Exception;
use Carbon\Carbon;

use App\Http\Controllers\MeetingController;



class CommonController extends Controller
{
    use LivewireAlert;

    public function updatePasssword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|required_with:password|same:password'
        ]);

        $user = auth()->user();
        if (Hash::check($request->old_password, $user->password)) {

            if (!Hash::check($request->password, $user->password)) {
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
                'g-recaptcha-response' => 'required|recaptcha',

            ]
        );

        $contact = new Supports;
        $contact->user_id = auth()->check() ? auth()->user()->id : null;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->first_name;
        $contact->email = $request->email;
        $contact->reason = $request->reason;
        $contact->message = $request->message;
        $contact->save();

        Notification::route('mail', env('ADMIN_EMAIL'))->notify(new SupportNotification($contact));
        //Notification::route('mail', 'info.gurpreetsaini@gmail.com')->notify(new SupportNotification($contact));

        //dd($request->all());

        $this->flash('success', 'Ticket Raised Successfully.');
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

        $date = date('Y-m-d');
        $date3Months = Carbon::parse($date)->subtract(3, 'months')->format('Y-m-d');
        
        $totalCount = $user->lawyerReviews()->count();
        $totalRating = $user->lawyerReviews()->sum('rating');
        
        $checkRating = 0;
        $overAllRating = 0;
        
        if($totalCount > 0){
            $overAllRating = $totalRating / $totalCount;
            
            
            $countCancleBookings = $user->booking()->where('is_canceled', '1')->where('booking_date', '>=', $date3Months)->count();
            
            
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
            //dd($newRating);
        
            $user->rating = number_format($newRating, 1);
        }
        else {
            $user->rating = '';
        }
        
        
        $cancelBooking = Booking::where('lawyer_id', $user->id)
                    ->where(function($query){
                        $query->where('is_accepted', '2');
                        $query->orWhere('is_canceled', '1');
                    })
                    ->get();
        
        $overAllRating = number_format($overAllRating, 1);
		
		
        
        $stateBar = StateBar::whereStatus('1')->get();
        $states = State::whereStatus('1')->pluck('name', 'id');

        return view('admin.lawyers.view-details', compact('title', 'user', 'categories', 'cancelBooking', 'checkRating', 'overAllRating', 'stateBar', 'states'));
    }

    public function viewUserDetails($id)
    {
        $title = array(
            'title' => 'View Client Details',
            'active' => 'client',
        );
        $user = User::where('id', $id)->first();
		  
		
		$cancelBooking = Booking::where('user_id', $user->id)
                    ->where(function($query){
                        $query->where('is_accepted', '2');
                        $query->orWhere('is_canceled', '1');
                    }) 
                    ->get();
					
        return view('admin.users.view-details', compact('title', 'user', 'cancelBooking'));
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
        if($user->status=='1'){
            $user->status = '0';
            $action = "deactivated";
        }
        else {
            $user->status = '1';
            $action = "activated";
        }

        $user->save();
        

        //...send mail

        Notification::route('mail', $user->email)->notify(new ResponseToLawyerRequest($user, $action));
        $this->flash('success', 'Lawyer '.$action.' successfully');
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
                //->where('is_canceled', '0')
                ->with('user', 'notes')->latest('id')->get();
            //   dd( $completeConsultations);
        } else {

            $completeConsultations = Booking::where('user_id', $authUser->id)
                ->where('is_call', 'completed')
                ->where('is_accepted', '0')
                //->where('is_canceled', '0')
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
        $booking = Booking::where('id', $id)
                        ->where('is_call', 'pending')
                        ->where('is_accepted', '0')
                        ->where('is_canceled', '0')
                        ->first();

        


        if (@$booking) {
            $booking->reschedule = '1';
            $booking->update();

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
        

        $this->flash('error', 'Invalid Consultation.');
        return redirect()->route('consultations.upcoming');

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
            
            
            $this->flash('success', 'Case Accepted');
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
            
            self::refundAmount($declineCase);
            

            Notification::route('mail', $declineCase->user_email)->notify(new UserMailForCaseStatus($declineCase, $status));

            Notification::route('mail', $declineCase->user_email)->notify(new CaseAcceptReviewNotification($declineCase, $authUser));


            //Notification::route('mail', $authUser->email)->notify(new LawyerMailForCaseStatus($declineCase, $status));


            $this->flash('success', 'Case declined successfully');
        } else {
            $this->flash('error', 'Something went wrong');
        }
        return back();
        return redirect()->route('consultations.accepted');
    }
    
    
    
    private function refundAmount($booking){
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        
        try {
                $refund = $stripe->refunds->create([
                    'charge' => $booking->payments->transaction_id,
                ]);

                if(@$refund){

                    //...
                    $booking->payment_process = '1';
                    $booking->transfer_client = '1';
                    $booking->save();

                    $store = new PaymentStatus;
                    $store->bookings_id = $booking->id;
                    $store->transaction_id = @$refund['id'];
                    $store->status = 'succeeded';
                    $store->amount = $booking->total_amount;
                    $store->save();

                }

            } catch (\Stripe\Exception\CardException $e) {
                $error = $e->getMessage();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
            
    }
    
    
    public function cancelCase($id)
    {
        $booking = Booking::where('id', $id)->first();
        //$booking->is_call = "completed";
        $booking->is_canceled = '1';
        $booking->update();

        self::refundAmount($booking);
        
        $this->flash('success', 'Case canceled successfully');
        
        return back();
        return redirect()->route('consultations.complete');
    }
    
    

    public function reschedule($id)
   {
        
        $booking = Booking::where('id', $id)
                        ->where('is_call', 'pending')
                        ->where('is_accepted', '0')
                        ->where('is_canceled', '0')
                        ->first();
        if(!$booking){
            $this->flash('error', 'Invalid Consultation.');
            return redirect()->route('consultations.upcoming');
        }
        
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



    public function thankYou($id)
    {
        $title = array(
            'title' => 'Thank You',
            'active' => 'thankYou',
        );

        $booking = Booking::findOrFail(decrypt($id));

        return view('pages.thankYou', compact('title', 'booking'));
    }


    public function consultationsCancel(Request $request)
    {
        $user = auth()->user();

        $booking = Booking::where('id', $request->id)->where('user_id', $user->id)->first();

        if(!$booking){
            abort(404);
        }

        try {
            $meeting = new MeetingController;
            $a = $meeting->destroy($booking);
        } catch (Exception $e) {
            //$error = $e->getMessage();
        }
        
        
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        
        $booking->is_canceled = '1';
        $booking->save();
        
        
        if(@$booking->payments->transaction_id){
            //when user cancel the booking
                    try {
                        
                        $refund = \Stripe\Refund::create([
                            'charge' => $booking->payments->transaction_id,
                            'amount' => $booking->consultation_fee * 100,
                        ]);
            
            
                        //dd($refund);
                        if(@$refund){

                            //...
                            $booking->payment_process = '1';
                            $booking->transfer_client = '1';
                            $booking->save();
        
                            $store = new PaymentStatus;
                            $store->bookings_id = $booking->id;
                            $store->transaction_id = @$refund['id'];
                            $store->status = 'succeeded';
                            $store->amount = $booking->consultation_fee;
                            $store->save();
                            
                            $this->flash('success', 'Booking Canceled');
                            return redirect()->back();
                        }
                        
                        $this->flash('error', 'Getting error in refund');
                        return redirect()->back();
                    } catch (\Stripe\Exception\CardException $e) {
                        $error = $e->getMessage();
                    } catch (Exception $e) {
                        $error = $e->getMessage();
                    }
                    
                    //self::refundAmount($booking);
                    $this->flash('error', 'Getting error in refund');
                    return redirect()->back();
                        
        
        }
        else {
        
        $this->flash('success', 'Booking Canceled');
        return redirect()->back();
        
        }
    }


        public function offerLawyer(Request $request, $id)
    {
        $request->validate([
            'offer_price' => 'required|numeric',
            'offer_price_yearly' => 'required|numeric',
        ]);
        
        $user = User::findOrFail($id);
        
        $user->offer_price = $request->offer_price;
        $user->offer_price_yearly = $request->offer_price_yearly;
        $user->save();
        
        
        $subscription = Subscription::where('type', $user->payment_plan)->first();
        
        ///sending email
        Notification::route('mail', $user->email)->notify(new OfferNotification($user, $subscription));
        
        
        $this->flash('success', 'Subscription offer added successfully');
        return back();
    }

    
}
