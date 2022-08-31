<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class ScheduleConsultationController extends Controller
{
    public function index($id)
    {
        $lawyerID = Crypt::decrypt($id);
        return view('pages.schedule-consultation', compact('lawyerID'));
    }

    
}
