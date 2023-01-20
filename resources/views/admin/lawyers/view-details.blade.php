@extends('layouts.app')
@section('content')

@php
$details = $user->details;
$lawyer_details = $user->lawyerInfo;

$lawyer_state_bar = $user->lawyerStateBar;
@endphp
<section class="lawyer-directory-profile-sec min-height-100vh lawyer_view">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Lawyer Profile</h2>
            <a href="{{ route('admin.lawyers.index') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Lawyers</a>
            <div class="lawyer_status btn_all_type">
                
				
                <div class="block_blocked">
					
					{{--
					<div >
						@if($user->status=="2")
						<a class="btn btn-sm btn-success " href="">Blocked</a>
						@else
						<form action="{{ route('admin.block.lawyer',$user->id) }}" method="post" id="formblock">
							@csrf
							<a class="btn btn-sm btn-success" onclick="blockFunction()">Block</a>
						</form>
						@endif
					</div>
					--}}
					
					<div>
						@if($user->status=="1")
						<form action="{{ route('admin.deactive.lawyer', $user->id) }}" method="post" id="formdeactive">
							@csrf
							<a class="btn btn-sm btn-success" onclick="deActiveFunction()">De-activate Account</a>
						</form>
						@else
						<form action="{{ route('admin.deactive.lawyer', $user->id) }}" method="post" id="formdeactive">
							@csrf
							<a class="btn btn-sm btn-success" onclick="activateFunction()">Activate Account</a>
						</form>
						@endif
						
					</div>
				</div>
				
				
                <div>
					
					
                    @if(@$user->details->review_request=='1' && $user->details->is_verified=='no')
					
                    <form action="{{ route('admin.accept.lawyer',$user->id) }}" method="post" id="formaccept">
                        @csrf
                        <a class="btn btn-sm btn-success" onclick="acceptFunction()">Accept</a>
					</form>
				</div>
                <div>
                    <form action="{{ route('admin.declined.lawyer',$user->id) }}" method="post" id="formdeclined">
                        @csrf
                        <a class="btn btn-sm btn-success" onclick="declinedFunction()">Decline</a>
					</form>
                    @endif
				</div>
			</div>
		</div>
		
		
        <div class="directory-profile-wrapper">
			<div class="row">
				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
					<div class="white-shadow-third-box" style="height: auto;">
						<div class="lawyer-hire-block">
							<div class="lawyers-img-block">
								<img src="{{ $user->profile_pic }}">
							</div>
							<div class="lawyers-service-cntnt-block">
								
								<div class="rating_block">
                                    <p class="">Actual Rating:<br> {{ @$overAllRating }}</p>
                                    <p class="">Deducted Rating:<br> {{ @$checkRating }}</p>
                                    <p class="">Overall Rating:<br> {{ @$user->rating }}</p>
								</div>
								
								<div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
									<h4 class="lawyer-name">{{ @$user->name }}</h4>
									<button class="hire-price-btn">${{ @$user->details->hourly_fee }}/hr.</button>
								</div>
								<div class="lawyers-desc_service d-flex justify-content-spacebw">
									<div class="years_experience_div">
										<p>YEARS EXP.</p>
										<h4>{{ @$user->details->year_experience }}</h4>
									</div>
									<div class="contingency-cases_div">
										<p>CONTINGENCY CASES</p>
										<h4>{{ @ucfirst($user->details->contingency_cases) }}</h4>
									</div>
									<div class="consult-fee_div">
										<p>CONSULT FEE</p>
										<h4>{{ @$user->details->is_consultation_fee=='yes' ? '$'.$user->details->consultation_fee : 'Free' }}</h4>
									</div>
								</div>
								<p class="school_name"><i class="fa-solid fa-school-flag"></i> {{ @$user->details->school_attendent }}</p>
								<div class="location_profile-divs">
									<address><i class="fa-solid fa-location-dot"></i> {{ @$user->details->city }}, {{ @$user->details->states->code }}</address>
								</div>
								
								<br/>
								
								<form action="{{ route('admin.subscription.offer', $user->id) }}" method="post">
									@csrf
									<p>Custom Subscription Price</p>
									<div class="form-grouph input-design">
                                        <label>Monthly Price</label>
                                        <input type="text" name="offer_price" value="{{ @$user->offer_price }}" required>
                                        {!! $errors->first('offer_price', '<span class="help-block">:message</span>') !!}
									</div>
									
									<div class="form-grouph input-design">
                                        <label>Yearly Price</label>
                                        <input type="text" name="offer_price_yearly" value="{{ @$user->offer_price_yearly }}" required>
                                        {!! $errors->first('offer_price_yearly', '<span class="help-block">:message</span>') !!}
									</div>
									
									
									<button type="submit" class="btn btn-sm btn-success mt-2">Save</button>
								</form>
								
								
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 admin_laywer_table">
					<div class="white-shadow-third-box lawyer-directory_about-block" style="height: auto;">
						
						
						<div class="form-grouph input-design{!! ($errors->has('profile_url') ? ' has-error' : '') !!}">
							{!! Form::label('profile_url','Profile URL', ['class' => 'form-label']) !!}
							{!! Form::text('profile_url', lawyerProfileUrl($user), ['class' => ($errors->has('profile_url') ? ' is-invalid' : ''), 'readonly']) !!}
							{!! $errors->first('profile_url', '<span class="help-block">:message</span>') !!}
						</div>
						
						@if(@$user->details)
						<div class="grey-light-heading">
							<h4>About {{ @$user->name }}</h4>
						</div>
				
						<div class="lawyer_profile-description">
							{!! @$user->details->bio !!}
						</div>
						
						
						{{--
						<div class="form-grouph select-design mt-2">
							@foreach ($categories as $category)
							<div class="form-grouph input-design">
								<label> {{ $category->name }}*</label>
							</div>
							<select name="lawyer_info[{{$category->id}}]" disabled>
								<option value="">Select {{ $category->name }}</option>
								@foreach($category->items as $i => $list)
								<option value="{{$list->id}}" @foreach ($lawyer_details as $i=> $item) {{ ( $list->id== $item->item_id) ? 'selected' : '' }} @endforeach >
									{{$list->name}}
								</option>
								@endforeach
							</select>
							{!! $errors->first('lawyer_info.'.$category->id, '<span class="help-block">:message</span>') !!}
							@endforeach
						</div>
						--}}
						
						<div class="grey-light-heading">
							<div class="d-flex align-items-center justify-content-spacebw">
								{!! Form::label('contingency_cases','Do you accept contingency cases', ['class' => 'form-label']) !!}
								<div class="d-flex align-items-center">
									<div class="checkbox-design position-relative">
										<label>{{@$user->details->contingency_cases}}</label>
									</div>
									
								</div>
							</div>
						</div>
						<div class="grey-light-heading">
							<div class="d-flex align-items-center justify-content-spacebw">
								{!! Form::label('is_consultation_fee','Do you want to charge a consultation fee', ['class' => 'form-label']) !!}
								<div class="d-flex align-items-center">
									<div class="checkbox-design position-relative">
										<label>{{@$user->details->contingency_cases}}</label>
									</div>
								</div>
							</div>
						</div>
						<div class="form-flex">
							<div class="form-grouph input-design">
								{!! Form::label('hourly_fee','Hourly Fee*', ['class' => 'form-label']) !!}
								{!! Form::number('hourly_fee', $user->details->hourly_fee ?? null, ['disabled' => true,'class' => ($errors->has('hourly_fee') ? ' is-invalid' : '')]) !!}
								
							</div>
							<div class="form-grouph input-design" id="consultation_fee">
								{!! Form::label('consultation_fee','Consultation Fee*', ['class' => 'form-label']) !!}
								{!! Form::number('consultation_fee', $user->details->consultation_fee ?? null, ['disabled' => true,'class' => ($errors->has('consultation_fee') ? ' is-invalid' : '')]) !!}
								
							</div>
						</div>
						
						<div class="form-grouph input-design">
							{!! Form::label('website_url','Website URL', ['class' => 'form-label']) !!}
							{!! Form::url('website_url', $user->details->website_url ?? null, ['disabled' => true,'class' => ($errors->has('website_url') ? ' is-invalid' : '')]) !!}
							
						</div>
						
						<div class="form-flex">
							<div class="form-grouph input-design">
								{!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
								{!! Form::text('first_name', $user->first_name ?? null, ['disabled' => true,'class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
								
							</div>
							<div class="form-grouph input-design">
								{!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
								{!! Form::text('last_name', $user->last_name ?? null, ['disabled' => true,'class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
								
							</div>
						</div>
						
						<div class="form-flex">
							<div class="form-grouph input-design">
								{!! Form::label('contact_number','Phone', ['class' => 'form-label']) !!}
								{!! Form::text('contact_number', $user->contact_number ?? null, ['disabled' => true,'class' => ($errors->has('contact_number') ? ' is-invalid' : '')]) !!}
								
							</div>
							<div class="form-grouph input-design">
								{!! Form::label('email','Email', ['class' => 'form-label']) !!}
								{!! Form::email('email', $user->email ?? null, ['disabled' => true,'class' => ($errors->has('email') ? ' is-invalid' : ''), 'disabled']) !!}
								
							</div>
						</div>
						
						<div class="form-grouph input-design">
							{!! Form::label('address','Address*', ['class' => 'form-label']) !!}
							{!! Form::text('address', $user->details->address ?? null, ['disabled' => true,'class' => ($errors->has('address') ? ' is-invalid' : '')]) !!}
							
						</div>
						
						<div class="form-flex three-columns">
							<div class="form-grouph input-design">
								{!! Form::label('city','City*', ['class' => 'form-label']) !!}
								{!! Form::text('city', $user->details->city ?? null, ['disabled' => true,'class' => ($errors->has('city') ? ' is-invalid' : '')]) !!}
								
							</div>
							<div class="form-grouph pt-3 select-design{!! ($errors->has('states_id') ? ' has-error' : '') !!}">
								{!! Form::label('states_id','State*', ['class' => 'form-label']) !!}
								{!! Form::select('states_id', $states, $details->states_id ?? null, ['class' => ($errors->has('states_id') ? ' is-invalid' : ''), 'disabled' => true]) !!}
								{!! $errors->first('states_id', '<span class="help-block">:message</span>') !!}
							</div>
							<div class="form-grouph input-design">
								{!! Form::label('zip_code','Zip Code*', ['class' => 'form-label']) !!}
								{!! Form::text('zip_code', $user->details->zip_code ?? null, ['disabled' => true,'class' => ($errors->has('zip_code') ? ' is-invalid' : '')]) !!}
								
							</div>
						</div>
						
						<!-- practice area -->
						<h3 class="pt-3">Areas of Practice </h3>
						<div class="practice_area">
							<h5>Litigations</h5>
							<ul>
								@foreach ($user->lawyerlitigations as $lawyerlitigation)
								<div class="form-grouph input-design">
									<li>{{@$lawyerlitigation->litigation->name}}</li>
								</div>
								@endforeach
							</ul>
							<h5>Contracts</h5>
							<ul>
								@foreach ($user->lawyerContracts as $lawyerContract)
								<div class="form-grouph input-design">
									<li>{{@$lawyerContract->contract->name}}</li>
								</div>
								@endforeach
							</ul>
						</div>
						
						
						
						
						
						
						<div class="form-grouph select-design">
							<div class="form-grouph input-design">
								<h5 class="h5_titile_form pt-3">State bar admissions</h5>
							</div>
							<select id="mstate" name="state_category" class="select-block multiBoxes" multiple readonly>
								@foreach ($stateBar as $state)
								<option value="{{$state->id}}" data-name="{{$state->name}}"
								@foreach ($lawyer_state_bar as $i=> $item)
									@if($state->id==$item->state_bar_id)
									data-year="{{$item->year_admitted}}"
									data-bar="{{$item->bar_number}}"
									selected
									@endif
									@endforeach
									>
									{{$state->name}}
								</option>
								@endforeach
							</select>
							{!! $errors->first('state_category', '<span class="help-block">:message</span>') !!}
							<div class="stateHtml cat"></div>
						</div>
						
						
						
						
						<div class="form-grouph select-design">
							<div class="form-grouph input-design">
								<h5 class="h5_titile_form pt-3">Federal court admissions</h5>
							</div>
							<select id="mcategory" name="lawyer_category" class="select-block multiBoxes" multiple readonly>
								
								
								@foreach ($categories as $category)
								<optgroup label="{{ $category->name }}">
									@foreach($category->items as $i => $list)
									<option value="{{$list->id}}" data-cat="{{$category->id}}" data-name="{{$list->name}}" 
									@foreach ($lawyer_details as $i=> $item)
										@if($list->id==$item->item_id)
										data-year="{{$item->year_admitted}}"
										data-bar="{{$item->bar_number}}"
										selected
										@endif
										@endforeach
										>
										{{$list->name}}
									</option>
									@endforeach
								</optgroup>
								@endforeach
							</select>
							{!! $errors->first('lawyer_category', '<span class="help-block">:message</span>') !!}
							<div class="admissionHtml cat"></div>
						</div>
						
						
						<div class="form-grouph input-design{!! ($errors->has('year_experience') ? ' has-error' : '') !!}">
							<div class="question_div">
								<label class="w-auto">Years of Experience </label> 
								<div class="tooltip_div">
									<span  class="tooltip1">?</span>
									<p class="cntent_txt">Courtroom Experience</p>
								</div>
							</div>
							{!! Form::text('year_experience', $details->year_experience ?? null, ['class' => ($errors->has('year_experience') ? ' is-invalid' : ''), 'maxlength'=>'2', 'readonly']) !!}
							{!! $errors->first('year_experience', '<span class="help-block">:message</span>') !!}
						</div>
						
						
						
						{{--
						@include('lawyer.profile.hours')
						--}}
					</div>
					@else
					
					<h4>Profile not updated by lawyer</h4>
					@endif
				</div>
				
				@livewire('admin.consultations', ['lawyerId' => $user->id, 'field'=>'lawyer_id'])
				
				
				<div class="col-md-12  mt-3 col-sm-12 ">
					<div class="white-shadow-third-box">
						<h2 class="text-center">Canceled Consultations</h2>
						<div class="lawyer_conultation-wrapper">
							<div class="table-responsive table-design">
								<table style="width:100%" class="admin_canceled_consulations" id="laravel_datatable">
									<thead>
										<tr>
											<th>Client Name</th>
											<th>Email</th>
											<th>Date</th>
											<th>Practice Area</th>
										</tr>
									</thead>
									<tbody>
										@foreach($cancelBooking as $booking)
										<tr>
											<td>{{$booking->user->name}}</td>
											<td>{{$booking->user->email}}</td>
											<td>{{date('m/d/Y', strtotime($booking->booking_date)) }}</td>
											<td>
												@if($booking->search_data)
												@php
												$search = json_decode($booking->search_data);
												@endphp
												@foreach($search as $id)
												@if($booking->search_type == 'litigations')
												{{ litigationsData($id) }}
												@else
												{{ contractsData($id) }}
												@endif
												@endforeach
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection


@section('script')
<div class="layoutHtml" style="display: none;">
    <div>
        <div class="layout layout_0id0">
            <div class="grey-light-heading">
                <h4>0itemTitle0</h4>
			</div>
            <div class="form-flex">
                <div class="form-grouph input-design">
                    <label for="bar_number" class="form-label">Bar Number*</label>
                    <input maxlength="20" required="required" name="lawyer_address[0key0][data][0key1][bar_number]" type="text" value="0bar0">
                    
				</div>
                <div class="form-grouph input-design">
                    <label for="year_admitted" class="form-label">Year Admitted*</label>
                    <input maxlength="4" required="required" name="lawyer_address[0key0][data][0key1][year_admitted]" type="text" value="0year0">
				</div>
			</div>
		</div>
	</div>
</div>


<div class="stateHtmlDom" style="display: none;">
    <div>
        <div class="layout layout_0id0">
            <div class="grey-light-heading">
                <h4>0itemTitle0</h4>
			</div>
            <div class="form-flex">
                <div class="form-grouph input-design">
                    <label for="bar_number" class="form-label">Bar Number*</label>
                    <input maxlength="20" required="required" name="lawyer_state[0key0][bar_number]" type="text" value="0bar0">
                    
				</div>
                <div class="form-grouph input-design">
                    <label for="year_admitted" class="form-label">Year Admitted*</label>
                    <input maxlength="4" required="required" name="lawyer_state[0key0][year_admitted]" type="text" value="0year0">
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function callAdmission(){
		
        let newHtml = '';
        var html = $('.layoutHtml').html();
		
        $.each($('#mcategory').find(":selected"), function (i, item) { 
            let id = $(item).attr("data-cat");
            let itemId = $(item).attr("value");
            let name = $(item).attr("data-name");
            let year = $(item).attr("data-year");
            let bar = $(item).attr("data-bar");
			
            //console.log(item)
            //console.log('year', year)
            //console.log('bar', bar)
			
            //...
            let html1 = html.replace(/0key0/g, id);
            html1 = html1.replace(/0id0/g, id);
            html1 = html1.replace(/0key1/g, itemId);
            html1 = html1.replace(/0itemTitle0/g, name);
            html1 = html1.replace(/0year0/g, year ?? '');
            html1 = html1.replace(/0bar0/g, bar ?? '');
			
            newHtml += html1;
			
			
            
		});
        
        //...
        $('.admissionHtml.cat').html(newHtml);
		
	}
    //...
    callAdmission();
	
	
	
	function callStateAdmission(){
		
        let newHtmlState = '';
        var html = $('.stateHtmlDom').html();
		
        $.each($('#mstate').find(":selected"), function (i, item) { 
            let id = $(item).attr("value");
            let name = $(item).attr("data-name");
            let year = $(item).attr("data-year");
            let bar = $(item).attr("data-bar");
			
            //...
            let html1 = html.replace(/0key0/g, id);
            html1 = html1.replace(/0id0/g, id);
            html1 = html1.replace(/0itemTitle0/g, name);
            html1 = html1.replace(/0year0/g, year ?? '');
            html1 = html1.replace(/0bar0/g, bar ?? '');
			
            newHtmlState += html1;
		});
        
        //...
        $('.stateHtml.cat').html(newHtmlState);
		
	}
    //...
    callStateAdmission();
	
	
	
	
	
	
	
	
    function blockFunction() {
		
        Swal.fire({
            title: "Are you sure you want to block this?",
            //text: "Block lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, block!",
            closeOnConfirm: false
			
			}).then((result) => {
			
            if (result.isConfirmed) {
                $("#formblock").submit();
			}
		});
		
		
	}
	
    function deActiveFunction() {
		
        Swal.fire({
            title: "Are you sure you want to de-active this?",
            //text: "De-active lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, De-active!",
            closeOnConfirm: false
			
			}).then((result) => {
			
            if (result.isConfirmed) {
                $("#formdeactive").submit();
			}
		});
	}
	
	
    function activateFunction() {
		
        Swal.fire({
            title: "Are you sure you want to active this?",
            //text: "Active lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Active!",
            closeOnConfirm: false
			
			}).then((result) => {
			
            if (result.isConfirmed) {
                $("#formdeactive").submit();
			}
		});
	}
	
	
    
	
	
    function acceptFunction() {
		
        Swal.fire({
            title: "Are you sure you want to accept this?",
            //text: "Accept lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Accept!",
            closeOnConfirm: false
			
			}).then((result) => {
			
            if (result.isConfirmed) {
                $("#formaccept").submit();
			}
		});
	}
	
    function declinedFunction() {
		
        Swal.fire({
            title: "Are you sure you want to decline this?",
            //text: "Decline lawyer!",
            //type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Decline!",
            closeOnConfirm: false
			
			}).then((result) => {
			
            if (result.isConfirmed) {
                $("#formdeclined").submit();
			}
		});
	}
</script>

@endsection