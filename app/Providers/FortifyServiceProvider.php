<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
			$title = array(
				'title' => 'Login',
				'active' => 'login'
			);
			return view('auth.login', compact('title'));
		});
	
		Fortify::authenticateUsing(function (Request $request) {
			
			$request->validate([
				'email' => 'required',
				'password' => 'required',
			]);
			
			$user = User::where('email', $request->email)->first();
			
			if ($user &&
				Hash::check($request->password, $user->password)) {
				return $user;
			}
		});
		
		Fortify::registerView(function () {
			$title = array(
				'title' => 'Register New Account',
				'active' => 'register'
			);
			return view('auth.register', compact('title'));
		});
		
		
		Fortify::requestPasswordResetLinkView(function () {
			$title = array(
				'title' => 'Forgot Password',
				'active' => 'forgot'
			);
			return view('auth.forgot-password', compact('title'));
		});

		Fortify::resetPasswordView(function ($request) {
			$title = array(
				'title' => 'Reset Password',
				'active' => 'forgot'
			);
			return view('auth.reset-password', compact('title', 'request'));
		});

		Fortify::verifyEmailView(function () {
			$title = array(
				'title' => 'Verify Email',
				'active' => 'verify'
			);
			return view('auth.verify-email', compact('title'));
		});

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // register new LoginResponse & RegisterResponse
		$this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class,
        );
		
		$this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
        );
        
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        // RateLimiter::for('two-factor', function (Request $request) {
        //     return Limit::perMinute(5)->by($request->session()->get('login.id'));
        // });
    }
}
