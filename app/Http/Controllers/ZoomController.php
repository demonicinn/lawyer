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

		$booking = Booking::where('zoom_id', $request->id)
					->where('booking_date', '>=', date('Y-m-d'))
					->where(function($query) use($user) {
						$query->where('user_id', $user->id);
						$query->orWhere('lawyer_id', $user->id);
					})
					->first();
		
		if(!$booking){
			abort(404);
		}

        return view('common.zoom', compact('title', 'booking', 'user'));
    }


    //
    public function leave(Request $request)
    {																					
		$user = auth()->user();

		$booking = Booking::where('zoom_id', $request->id)
					//->where('booking_date', '>=', date('Y-m-d'))
					->where(function($query) use($user) {
						$query->where('user_id', $user->id);
						$query->orWhere('lawyer_id', $user->id);
					})
					->where('is_call', 'pending')
					->first();
		
		$this->flash('success', 'Meeting successfully completed.');

		if(!$booking){
			return redirect()->route('home');
		}

		//...
		$booking->is_call = 'completed';
		$booking->save();


        return redirect()->route('home');
    }


}
