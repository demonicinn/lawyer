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
		
        return view('lawyer.dashboard.index', compact('user', 'title'));
    }
}
