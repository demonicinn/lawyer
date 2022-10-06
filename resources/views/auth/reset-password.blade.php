@extends('layouts.app')
@section('content')
<section class="body-banner authentication-sec min-height-100vh login-sec">
	<div class="container">
		<div class="authentication-container">
			<div class="authentication-header">
				<h2>CReset Password</h2>
			</div>
			<div class="lawyer-login">
				{!! Form::open(['route' => 'password.update', 'class'=>'user']) !!}
				<input type="hidden" name="token" value="{{ request()->route('token') }}">
				<div class="white-shadow-box">

					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('email','Email', ['class' => 'form-label']) !!}
						{!! Form::email('email', request()->email ?? null, ['class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
					</div>

					<div class="form-grouph input-design{!! ($errors->has('password') ? ' has-error' : '') !!}">
						{!! Form::label('password','Password', ['class' => 'form-label']) !!}
						<input type="password" id="password" name="password" class="{!! ($errors->has('password') ? ' is-invalid' : '') !!}" />
						{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
					</div>

					<div class="form-grouph input-design{!! ($errors->has('password') ? ' has-error' : '') !!}">
						{!! Form::label('password_confirmation','Confirm Password', ['class' => 'form-label']) !!}
						<input type="password" id="password_confirmation" name="password_confirmation" class="{!! ($errors->has('password') ? ' is-invalid' : '') !!}" />
						{!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
					</div>

					<div class="form-grouph submit-design text-center">
						<button class="form-btn" type="submit">{{ __('Reset Password') }}</button>
					</div>

				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>
@endsection