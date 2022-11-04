@extends('layouts.app')
@section('content')
<section class="body-banner portal-inner-page-sec">
      <div class="container">
         <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
         </div>
        <div class="portal-page-wrapper">
           <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="portal-div-design position-relative">
                <div class="portal-div-img">
                  <img src="assets/images/schedule.svg">
                </div>
                <div class="portal-cntnt-wrapper">
                   <a href="{{ route('consultations.upcoming') }}">Consultation</a>

                </div>
                {{--
                <div class="dropdown">
                  <button type="button" class="options-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>                  
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Link 1</a></li>
                    <li><a class="dropdown-item" href="#">Link 2</a></li>
                    <li><a class="dropdown-item" href="#">Link 3</a></li>
                  </ul>
                </div>
                --}}
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="portal-div-design position-relative">
                <div class="portal-div-img">
                  <img src="assets/images/saved-lawyers.svg">
                </div>
                <div class="portal-cntnt-wrapper">
                   <a href="{{ route('user.saved.lawyer') }}">Saved Lawyers</a>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="portal-div-design position-relative">
                <div class="portal-div-img">
                  <img src="assets/images/account-portal.svg">
                </div>
                <div class="portal-cntnt-wrapper">
                   <a href="{{ route('user.profile') }}">Account</a>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="portal-div-design position-relative">
                <div class="portal-div-img">

                  <img src="assets/images/account-portal.svg">
                </div>
                <div class="portal-cntnt-wrapper">
                   <a href="{{ route('user.billing.index') }}">Billing</a>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
              <div class="portal-div-design position-relative">
                <div class="portal-div-img">

                  <img src="assets/images/services-portal.svg">
                </div>
                <div class="portal-cntnt-wrapper">
                   <a href="{{route('support')}}">Support</a>
                </div>
              </div>
            </div>
           </div>
        </div>
      </div>
    </section>
@endsection