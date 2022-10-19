<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
		$title = array(
			'title' => 'Lawyer Portal',
			'active' => 'dashboard',
		);
		
		$user = auth()->user();


		$upcomingConsultations = $user->booking()
									->where('booking_Date', '>=', date('Y-m-d'))
									->where('is_call', 'pending')
									->where('is_accepted', '0')
                                    ->where('is_canceled', '0')
									->count();

		$completeConsultations = $user->booking()
									->where('is_call', 'completed')
									->where('is_accepted', '0')
                                    ->where('is_canceled', '0')
									->count();

		$acceptedConsultations = $user->booking()
									->where('is_call', 'completed')
									->where('is_accepted', '1')
                                    ->where('is_canceled', '0')
									->count();

		$data = array(
			'title' => $title,
			'user' => $user,
			'upcomingConsultations' => $upcomingConsultations,
			'completeConsultations' => $completeConsultations,
			'acceptedConsultations' => $acceptedConsultations,
		);


		
        return view('lawyer.dashboard.index', $data);
    }
}
