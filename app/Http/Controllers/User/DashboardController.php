<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $title = array(
			'title' => 'User Portal',
			'active' => 'dashboard',
		);
		
		$user = auth()->user();
		
        return view('user.dashboard.index', compact('user', 'title'));
    }
}
