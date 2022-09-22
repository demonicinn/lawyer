@extends('layouts.app')
@section('content')
<section class="body-banner lawyer-directory-profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Directory Profile</h2>
            <a href="{{ url()->previous() ?? route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Lawyers</a>
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
                            <div class="grey-light-heading">
                                <h4>About {{ @$user->name }}</h4>
                            </div>
                            <div class="lawyer_profile-description">
                                {!! @$user->details->bio !!}

                                @if (Auth::check())

                               
                                @if ( !empty($user->savedLawyer) && $user->savedLawyer->user_id==Auth::user()->id)
                                <div class="save_btn text-center">
                                    <a href="#" class="btn-design-first" title="Already Saved">Saved Attorney</a>
                                </div>
                                @else
                                <div class="save_btn text-center">
                                    <a href="{{route('user.save.lawyer',$lawyerID)}}" class="btn-design-first">Save Attorney</a>
                                </div>
                                @endif

                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection