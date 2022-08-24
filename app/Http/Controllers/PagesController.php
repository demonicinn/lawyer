<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Litigation;
use App\Models\Contract;

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

        $litigations = Litigation::whereStatus('1')->get();
        return view('pages.litigations', compact('title','litigations'));
    }

    //
    public function contracts()
    {
		$title = array(
			'title' => 'Narrow Down Contracts',
			'active' => 'contracts',
		);
		$contracts = Contract::whereStatus('1')->get();
        return view('pages.contracts', compact('title','contracts'));
    }

    //
    public function lawyers(Request $request)
    {
        $route = "narrow.litigations";
        if(@$request->contracts){
            $route = "narrow.contracts";
        }
        return view('pages.lawyers', compact('route'));
    }

}
