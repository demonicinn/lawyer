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

					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('email','Email', ['class' => 'form-label']) !!}
						{!! Form::email('email', request()->email ?? null, ['class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
					</div>

					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('password','Password', ['class' => 'form-label']) !!}
						<input type="password" id="password" name="password" class="{!! ($errors->has('email') ? ' is-invalid' : '') !!}" />
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