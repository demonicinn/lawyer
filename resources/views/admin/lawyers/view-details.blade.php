@extends('layouts.app')
@section('content')

@php
$details = $user->details;
$lawyer_details = $user->lawyerInfo;

@endphp
<section class="body-banner lawyer-directory-profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Lawyer Profile</h2>
            <a href="{{ url()->previous() ?? route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Lawyers</a>
            <div class="lawyer_status">
                <div>
                    @if($user->status=="2")
                    <a class="btn btn-sm btn-success" href="">Blocked</a>
                    @else
                    <form action="{{ route('admin.block.lawyer',$user->id) }}" method="post" id="formblock">
                        @csrf
                        <a class="btn btn-sm btn-success" onclick="blockFunction()">Block</a>
                    </form>
                    @endif
                </div>

                <div>
                    <form action="{{ route('admin.deactive.lawyer',$user->id) }}" method="post" id="formdeactive">
                        @csrf
                        <a class="btn btn-sm btn-success" onclick="deActiveFunction()">De-active</a>
                    </form>
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
            <form class="directory-form-information form-design">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="white-shadow-third-box">
                            <div class="lawyer-hire-block">
                                <div class="lawyers-img-block">
                                    <img src="{{ $user->profile_pic }}">
                                </div>
                                <div class="lawyers-service-cntnt-block">
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
                                    <p class="school_name"><i class="fa-solid fa-school-flag"></i> Harvard Law School</p>
                                    <div class="location_profile-divs">
                                        <address><i class="fa-solid fa-location-dot"></i> {{ @$user->details->city }}, {{ @$user->details->states->code }}</address>
                                    </div>
                                    @php $lawyerID= Crypt::encrypt($user->id); @endphp
                                    <div class="schedular_consultation">
                                        <a href="{{route('schedule.consultation',$lawyerID)}}" class="schule_consultation-btn">Schedule Consultation</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="white-shadow-third-box lawyer-directory_about-block">
                            @if($user && $user->details->bio)
                            <div class="grey-light-heading">
                                <h4>About {{ @$user->name }}</h4>
                            </div>
                            <div class="lawyer_profile-description">
                                {!! @$user->details->bio !!}
                            </div>

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
                                    {!! Form::number('contact_number', $user->contact_number ?? null, ['disabled' => true,'class' => ($errors->has('contact_number') ? ' is-invalid' : '')]) !!}

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
                                <div class="form-grouph input-design">
                                    {!! Form::label('city','City*', ['class' => 'form-label']) !!}
                                    {!! Form::text('city', $user->details->city ?? null, ['disabled' => true,'class' => ($errors->has('city') ? ' is-invalid' : '')]) !!}

                                </div>
                                <div class="form-grouph input-design">
                                    {!! Form::label('zip_code','Zip Code*', ['class' => 'form-label']) !!}
                                    {!! Form::text('zip_code', $user->details->zip_code ?? null, ['disabled' => true,'class' => ($errors->has('zip_code') ? ' is-invalid' : '')]) !!}

                                </div>
                            </div>

                            <!-- practice area -->
                            <h3>Areas of Practice </h3>
                            <div class="practice_area">
                                <h5>Litigations</h5>
                                <ul>
                                    @foreach ($user->lawyerlitigations as $lawyerlitigation)
                                    <div class="form-grouph input-design">
                                        <li>{{@$lawyerlitigation->litigations->name}}</li>
                                    </div>
                                    @endforeach
                                </ul>
                                <h5>Contracts</h5>
                                <ul>
                                    @foreach ($user->lawyerContracts as $lawyerContract)
                                    <div class="form-grouph input-design">
                                        <li>{{@$lawyerContract->contracts->name}}</li>
                                    </div>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="grey-light-heading">
                                <h4>Texas</h4>
                            </div>
                            <div class="form-flex">
                                <div class="form-grouph input-design">
                                    {!! Form::label('bar_number','Bar Number*', ['class' => 'form-label']) !!}
                                    {!! Form::text('bar_number', $user->details->bar_number ?? null, ['disabled' => true,'class' => ($errors->has('bar_number') ? ' is-invalid' : ''), 'maxlength'=>'20']) !!}

                                </div>
                                <div class="form-grouph input-design">
                                    {!! Form::label('year_admitted','Year Admitted*', ['class' => 'form-label']) !!}
                                    {!! Form::text('year_admitted', $user->details->year_admitted ?? null, ['disabled' => true,'class' => ($errors->has('year_admitted') ? ' is-invalid' : ''), 'maxlength'=>'4']) !!}

                                </div>
                            </div>

                            <div class="form-grouph input-design">
                                <label>Years of Experience <span class="label_color">?</span></label>
                                {!! Form::text('year_experience', $user->details->year_experience ?? null, ['disabled' => true,'class' => ($errors->has('year_experience') ? ' is-invalid' : ''), 'maxlength'=>'2']) !!}

                            </div>
                            @include('lawyer.profile.hours')
                        </div>
                        @else

                        <h4>Profile not updated by lawyer</h4>
                        @endif
                    </div>
                    <div class="col-md-12 col-sm-12 mt-3">
                    <div class="white-shadow-third-box">
                        <h1>gelllooooo</h1>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
    function blockFunction() {

        Swal.fire({
            title: "Are you sure?",
            text: "Block lawyer!",
            type: "danger",
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
            title: "Are you sure?",
            text: "De-active lawyer!",
            type: "danger",
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

    function acceptFunction() {

        Swal.fire({
            title: "Are you sure?",
            text: "Accept lawyer!",
            type: "danger",
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
            title: "Are you sure?",
            text: "Decline lawyer!",
            type: "danger",
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