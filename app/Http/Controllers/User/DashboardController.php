<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = array(
            'title' => 'User Portal',
            'active' => 'dashboard',
        );

        $user = auth()->user();


        $upcomingConsultations = $user->bookingUser()
                                    ->where('booking_Date', '>=', date('Y-m-d'))
                                    ->where('is_call', 'pending')
                                    ->where('is_accepted', '0')
                                    ->where('is_canceled', '0')
                                    ->count();

        $completeConsultations = $user->bookingUser()
                                    ->where('is_call', 'completed')
                                    ->where('is_accepted', '0')
                                    ->where('is_canceled', '0')
                                    ->count();

        $acceptedConsultations = $user->bookingUser()
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

        return view('user.dashboard.index', $data);
    }

    

    public function savedLawyer(){
       
        $title = array(
            'title' => 'Saved Lawyers',
            'active' => 'savedlawyer',
        );
        
        return view('user.saved-lawyer', compact('title'));
    }
}
