<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function home()
    {
		$title = array(
			'title' => 'Home',
			'active' => 'home',
		);
		
        return view('pages.home', compact('title'));
    }


    //
    public function narrowDown()
    {
		$title = array(
			'title' => 'Narrow Down Candidates',
			'active' => 'narrowDown',
		);
		
        return view('pages.narrowDown', compact('title'));
    }

    //
    public function litigations()
    {
		$title = array(
			'title' => 'Narrow Down Litigations',
			'active' => 'litigations',
		);
		
        return view('pages.litigations', compact('title'));
    }

    //
    public function contracts()
    {
		$title = array(
			'title' => 'Narrow Down Contracts',
			'active' => 'contracts',
		);
		
        return view('pages.contracts', compact('title'));
    }







}
