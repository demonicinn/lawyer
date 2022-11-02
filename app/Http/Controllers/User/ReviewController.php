<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Booking;
use App\Models\LawyerReviews;

class ReviewController extends Controller
{
    //
    use LivewireAlert;
    
    public function index(Request $request)
    {
        $title = array(
            'title' => 'Rate your consultation',
            'active' => 'review',
        );

        $booking = Booking::findOrFail(decrypt($request->id));



        $checkReviewCount = LawyerReviews::where('booking_id', $booking->id)->count();

        if(@$checkReviewCount == '1'){
            $this->flash('error', 'You already Rated');
            return redirect()->route('consultations.complete');
        }
        else {
            if($booking->is_accepted=='1' && $checkReviewCount=='1'){
                return view('user.review.index', compact('title', 'booking'));
            }
        }

        

        return view('user.review.index', compact('title', 'booking'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required',
            'comment' => 'required',
        ]);


        $booking = Booking::findOrFail(decrypt($request->id));

        $store = new LawyerReviews;
        $store->booking_id = $booking->id;
        $store->lawyer_id = $booking->lawyer_id;
        $store->rating = $request->rating;
        $store->comment = $request->comment;
        $store->save();

      
        $this->flash('success', 'Rated successfully');
        return redirect()->route('consultations.complete');


    }



}
