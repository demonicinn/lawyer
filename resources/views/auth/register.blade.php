@extends('layouts.app')
@section('content')
@php
$states = \App\Models\State::whereStatus('1')->pluck('name', 'id');
@endphp
<section class="body-banner authentication-sec min-height-100vh signup-sec">
	<div class="container">
		<div class="authentication-container">
			<div class="authentication-header">
				<h2>Lawyer Sign Up</h2>
			</div>
			<div class="lawyer-login">
				{!! Form::open(['route' => 'register', 'method'=>'post', 'class'=>'form-design']) !!}
				<div class="white-shadow-box">
					<div class="form-flex">

						<div class="form-grouph input-design{!! ($errors->has('first_name') ? ' has-error' : '') !!}">
							{!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
							{!! Form::text('first_name', null, ['class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
							{!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('last_name') ? ' has-error' : '') !!}">
							{!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
							{!! Form::text('last_name', null, ['class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
							{!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
							{!! Form::label('email','Email*', ['class' => 'form-label']) !!}
							{!! Form::email('email', null, ['class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
							{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('zip_code') ? ' has-error' : '') !!}">
						    <div class="question_div">
							{!! Form::label('zip_code','Zip Code*', ['class' => 'form-label w-auto']) !!}
							<div class="tooltip_div">
								<span  class="tooltip1">?</span>
								<p class="cntent_txt">Enter your zip code and it will populate your city and state</p>
							</div>
							</div>
							{!! Form::text('zip_code', null, ['class' => ($errors->has('zip_code') ? ' is-invalid' : '')]) !!}
							{!! $errors->first('zip_code', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('city') ? ' has-error' : '') !!}">
							{!! Form::label('city','City*', ['class' => 'form-label']) !!}
							{!! Form::text('city', null, ['class' => ($errors->has('city') ? ' is-invalid' : '')]) !!}
							{!! $errors->first('city', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph select-design{!! ($errors->has('state') ? ' has-error' : '') !!}">
							{!! Form::label('state','State*', ['class' => 'form-label']) !!}
							{!! Form::select('state', $states, null, ['class' => ($errors->has('state') ? ' is-invalid' : ''), 'placeholder'=>'Select State']) !!}
							{!! $errors->first('state', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('password') ? ' has-error' : '') !!}">
							{!! Form::label('password','Password*', ['class' => 'form-label']) !!}
							<input type="password" id="password" name="password" class="{!! ($errors->has('password') ? ' is-invalid' : '') !!}" />
							{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
						</div>
						<div class="form-grouph input-design{!! ($errors->has('password') ? ' has-error' : '') !!}">
							{!! Form::label('password_confirmation','Confirm Password*', ['class' => 'form-label']) !!}
							<input type="password" id="password_confirmation" name="password_confirmation" class="{!! ($errors->has('password') ? ' is-invalid' : '') !!}" />
							{!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<div class="form-flex box_checkbox">
						<div class="form-grouph input-design{!! ($errors->has('term') ? ' has-error' : '') !!}">
							<input type="checkbox" id="term" name="term" class="{!! ($errors->has('term') ? ' is-invalid' : '') !!}" /><p>Accept the privacy policy and Terms & Conditions.</p>
							{!! $errors->first('term', '<div class="help-block">:message</div>') !!}
						</div>
					</div>
					<div class="form-grouph submit-design text-center">
						<button class="form-btn" type="submit">Get Started</button>
					</div>
					<div class="account-availblity-div text-center">
						<p class="mb-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
						<p>Looking for a lawyer? <a href="{{ route('narrow.down') }}">Click here</a></p>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</section>
@endsection

@section('script')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}"></script>

<script>
	var geocoder = new google.maps.Geocoder();
    $(document).on('change', '#zip_code', function(){
        var zipcode = $(this).val();
        var country = "United States";
		//console.log(zipcode)
        

        //...

        geocoder.geocode({ 'address': zipcode + ',' + country }, function (result, status) {

            var stateName = '';
            var cityName = '';

            var addressComponent = result[0]['address_components'];

            // find state data
            var stateQueryable = $.grep(addressComponent, function (x) {
                return $.inArray('administrative_area_level_1', x.types) != -1;
            });

            if (stateQueryable.length) {
                stateName = stateQueryable[0]['long_name'];

                var cityQueryable = $.grep(addressComponent, function (x) {
                    return $.inArray('locality', x.types) != -1;
                });

                // find city data
                if (cityQueryable.length) {
                    cityName = cityQueryable[0]['long_name'];
                    
                    $('#city').val(cityName);
                }
                 
                if (stateName.length) {
					$("#state option:contains("+stateName+")").attr('selected', 'selected');
				}
                //console.log('stateName', stateName)
                //console.log('cityName', cityName)
        
            }
        });


        
    });
    
</script>
@endsection