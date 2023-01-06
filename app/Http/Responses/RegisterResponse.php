<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RegisterResponse implements RegisterResponseContract {

    use LivewireAlert;
    public function toResponse($request) {
        
        $user = auth()->user();
        
        if($user->details->states_id!='43'){
            $request->session()->flash('danger', 'Thank you for sign up with Prickly Pear, Right now we are not accepting sign up outside the Texas area, we will inform you as soon as we will start accepting lawyers from Texas.');
            
            auth()->logout();

            return redirect('register');
        }
        
		return redirect()->route('lawyer.subscription');
    }
}