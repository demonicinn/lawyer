<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Models\Booking;

class ZoomController extends Controller
{
    use LivewireAlert;

    //
    public function index(Request $request)
    {
	
		$title = array(
			'title' => 'Zoom',
			'active' => 'zoom',
		);

		$user = auth()->user();

		$zoom_id = $request->id;
		$booking = Booking::where('zoom_start_url', 'like', '%'.$zoom_id.'%')
		            //where('zoom_id', $request->id)
					//->where('booking_date', '>=', date('Y-m-d'))
					->where(function($query) use($user) {
						$query->where('user_id', $user->id);
						$query->orWhere('lawyer_id', $user->id);
					})
					->first();
		//dd($booking);
		if(!$booking){
			//abort(404);

			$this->flash('error', 'Invalid Meeting Id');
        	return redirect()->route('home');
		}

        return view('common.zoom_cdn', compact('title', 'booking', 'user', 'zoom_id'));
    }

    
    public function meet(Request $request)
    {
		$title = array(
			'title' => 'Zoom',
			'active' => 'zoom',
		);

		$user = auth()->user();

		$booking = Booking::where('zoom_id', $request->mn)
					//->where('booking_date', '>=', date('Y-m-d'))
					->where(function($query) use($user) {
						$query->where('user_id', $user->id);
						$query->orWhere('lawyer_id', $user->id);
					})
					->first();
		
		if(!$booking){
			//abort(404);
		}

        return view('common.zoom_meet', compact('title', 'booking', 'user'));
    }


    //
    public function leave(Request $request)
    {
		$user = auth()->user();

		$booking = Booking::where('zoom_id', $request->id)
					//->where('booking_date', date('Y-m-d'))
					//->where('booking_time', '>', date('h:i:s'))
					->where(function($query) use($user) {
						$query->where('user_id', $user->id);
						$query->orWhere('lawyer_id', $user->id);
					})
					->where('is_call', 'pending')
					->first();
		
		

		if(!$booking){
			//$this->flash('success', 'Meeting successfully completed.');
			return redirect()->route('home');
		}

        $dateTime = date('Y-m-d h:i:s');
        $bookingDateTime = $booking->booking_date.' '.$booking->booking_time;

		//...
		if($user->role=='lawyer' && $dateTime > $bookingDateTime){
		    $booking->is_call = 'completed';
		    $booking->save();

		    $this->flash('success', 'Meeting successfully completed.');
		}
        
        return redirect()->route('consultations.complete');
    }


}
