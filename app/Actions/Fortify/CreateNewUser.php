<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Notifications\WelcomeNotification;
use App\Notifications\WelcomeNotTexasNotification;
use App\Notifications\MailToAdminNewRegistration;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use Illuminate\Support\Facades\Notification;

class CreateNewUser implements CreatesNewUsers
{
    use LivewireAlert;
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'city' => ['required', 'string', 'max:100'],
            'states_id' => ['required'],
            'zip_code' => ['required', 'string', 'max:100'],
            'term'=>['required'],
        ],[
            'term.required' => 'Please accept the privacy policy and Terms & Conditions.',
        ])->validate();

        $user = new User;
        $user->first_name = ucfirst($input['first_name']);
        $user->last_name = ucfirst($input['last_name']);
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        if($input['states_id']!='43'){
            $user->status = '0';
        }
        $user->save();

        $detail = new UserDetails;
        $detail->users_id = $user->id;
        $detail->city = $input['city'];
        $detail->states_id = $input['states_id'];
        $detail->zip_code = $input['zip_code'];
        $detail->save();


        if($input['states_id']!='43'){
            //send notification to lawyer
            Notification::route('mail', $user->email)->notify(new WelcomeNotTexasNotification($user));
        
            $this->flash('error', 'Thank you for sign up with Prickly Pear, Right now we are not accepting sign up outside the Texas area, we will inform you as soon as we will start accepting lawyers from Texas.');
            
        }
        else {
            //send notification to lawyer
            Notification::route('mail', $user->email)->notify(new WelcomeNotification($user));
    
            //send notification to admin
            Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new MailToAdminNewRegistration($user));
        }
        
        return $user;
    }
}
