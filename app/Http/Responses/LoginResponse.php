<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract {

    public function toResponse($request) {		
	
		$redirectUrl = session('link');

		if(@$redirectUrl){
			session(['link' => '']);
			return redirect($redirectUrl);
		}
		
		if (auth()->check()){
			$route = auth()->user()->role . '.dashboard';

		
			return redirect()->route($route);
		}
		
		return redirect()->route('account.index');
    }
}