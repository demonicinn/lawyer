@extends('layouts.app')
@section('content')
<section class="body-banner authentication-sec min-height-100vh login-sec">
	<div class="container">
		<div class="authentication-container">
			<div class="authentication-header">
				<h2>Change Password</h2>
			</div>
			<div class="lawyer-login">
				{!! Form::open(['route' => 'password.email', 'class'=>'user']) !!}
				<div class="white-shadow-box">

					<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
						{!! Form::label('email','Email', ['class' => 'form-label']) !!}
						{!! Form::email('email', request()->email ?? null, ['class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
					</div>

					<div class="form-grouph submit-design text-center">
						<button class="form-btn" type="submit">{{ __('Forgot Password') }}</button>
					</div>

				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>
@endsection