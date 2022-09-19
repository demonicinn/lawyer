<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ZoomController extends Controller
{
    //
    public function index(Request $request)
    {
		$title = array(
			'title' => 'Zoom',
			'active' => 'zoom',
		);

		$booking = Booking::where('zoom_id', $request->id)->first();

		$user = auth()->user();

		if(!$booking){
			abort(404);
		}

		if(!($booking->user_id == $user->id || $booking->lawyer_id == $user->id)) {
			abort(404);
		}

		if(date('Y-m-d') > $booking->booking_date) {
			abort(404);
		}

        return view('common.zoom', compact('title'));
    }


}
