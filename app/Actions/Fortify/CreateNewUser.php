<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Notifications\WelcomeNotification;
use App\Notifications\MailToAdminNewRegistration;

use Illuminate\Support\Facades\Notification;

class CreateNewUser implements CreatesNewUsers
{
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
            'state' => ['required'],
            'zip_code' => ['required', 'string', 'max:100'],
        ])->validate();

        $user = new User;
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        $detail = new UserDetails;
        $detail->users_id = $user->id;
        $detail->city = $input['city'];
        $detail->states_id = $input['state'];
        $detail->zip_code = $input['zip_code'];
        $detail->save();

        //send notification to lawyer
        Notification::route('mail', $user->email)->notify(new WelcomeNotification($user));

        //send notification to admin
        Notification::route('mail', env('MAIL_FROM_ADDRESS'))->notify(new MailToAdminNewRegistration($user));

        
        return $user;
    }
}
