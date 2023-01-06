@extends('layouts.app')
@section('content')
<section class="body-banner authentication-sec min-height-100vh login-sec">
	<div class="container">
		<div class="authentication-container">
			<div class="authentication-header">
				<h2>User Login</h2>
			</div>
			<div class="lawyer-login">
				{!! Form::open(['route' => 'login', 'class'=>'form-design']) !!}
				<div class="white-shadow-box">
                    
                    @if ($message = Session::get('dangerLogin'))
                    <div class="container alert-message">
                    	<div class="row">
                    		<div class="col-md-12">
                    			<div class="alert alert-danger alert-dismissible fade show">
                    				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    				<strong>Your account is not active, please contact <a href="{{ route('support') }}">support</a></strong>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    @endif
                    
					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('email','Email', ['class' => 'form-label']) !!}
						{!! Form::email('email', request()->email ?? null, ['class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
						{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
					</div>

					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('password','Password', ['class' => 'form-label']) !!}
						<input type="password" id="password" name="password" class="{!! ($errors->has('email') ? ' is-invalid' : '') !!}" />
						{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
					</div>


					@if (Route::has('password.request'))
					<div class="forgot-password text-center">
						<a href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a>
					</div>
					@endif

					<div class="form-grouph submit-design text-center">
						<button class="form-btn" type="submit">{{__ ('Login') }}</button>
					</div>

					@if (Route::has('register'))
					<div class="account-availblity-div text-center">
						<p>Don’t have an account? <a href="{{ route('register') }}">Sign Up.</a></p>
					</div>
					@endif
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>
@endsection