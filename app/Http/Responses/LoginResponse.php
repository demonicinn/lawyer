<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class LoginResponse implements LoginResponseContract {


    use LivewireAlert;
    
    public function toResponse($request) {		
	
		$redirectUrl = session('link');

		if(@$redirectUrl){
			session(['link' => '']);
			return redirect($redirectUrl);
		}
		
		if (auth()->check()){
		    
		    if(auth()->user()->status != '1'){
		        
		        $request->session()->flash('dangerLogin', 'Your account is not active, please contact support');
		        auth()->logout();
		        return redirect()->route('login');
		    }
		    else {
		    
    			$route = auth()->user()->role;
    			return redirect()->route($route);
		    }
		}
		
		return redirect()->route('login');
    }
}