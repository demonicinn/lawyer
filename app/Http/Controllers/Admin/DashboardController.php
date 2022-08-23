<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
		$title = array(
			'title' => 'Dashboard',
			'active' => 'dashboard',
		);
		
		$user = auth()->user();
		
        return view('admin.dashboard.index', compact('user', 'title'));
    }

    

}
