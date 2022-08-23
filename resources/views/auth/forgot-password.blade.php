@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-lg-6 d-none d-lg-block ">
		<!-- slider html here -->
		@include('auth.slider')
	</div>

	<div class="col-lg-6">
		<div class="p-5 pt-100">
			<div class="text-center">
				<h1 class="h4 h4_tittle ">Change Password</h1>
				<p class="mb-4 p_text">Automate demand planning, category management, and the
				end-to-end process for the entire operation. </p>
			</div>
			{!! Form::open(['route' => 'password.email', 'class'=>'user']) !!}
				
				<div class="form-outline{!! ($errors->has('email') ? ' has-error' : '') !!}">
					{!! Form::email('email', request()->email ?? null, ['class' => 'form-control'.($errors->has('email') ? ' is-invalid' : '')]) !!}
					{!! Form::label('email','Email Address', ['class' => 'form-label']) !!}
				</div>							
				
				<div class="form-group btn_login_sign pt-5">
					<button class="btn btn-danger btn-user btn_s">
						{{__ ('Forgot Password') }}
					</button>
				</div>				
				
			{!! Form::close() !!}

			<div class="text-center pt-3">
				{{__ ("Already have an account?") }} <a class="red_link" href="{{ route('login') }}"><b>{{__ ("Sign In") }}</b></a>
			</div>
			
		</div>
	</div>
</div>
@endsection