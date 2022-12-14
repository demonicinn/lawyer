@extends('layouts.app')
@section('content')
<section class="body-banner thanks_booking-sec min-height-100vh " style="background-image: url('{{ asset('assets/images/home-banner.png') }}');">
  <div class="container">
  <div class="white-shadow-third-box">
         <div class="heading-paragraph-design text-center mb-5">
          <h2>Thank you for booking</h2>
         </div>
        <div class="booking-info_profile-flex">
          <div class="booking-info-left_column">
             <img src="{{ $booking->lawyer->profile_pic }}">
          </div>
          <div class="booking-info-right_column">
             <h4 class="booking_name">{{ $booking->lawyer->name }}</h4>
             <h5 class="booking_type-text">Admiralty/Maritime</h5>
             <p class="booking_date-time">{{ date('l, F d Y', strtotime($booking->booking_date)) }} <span class="divider-horizonatl"></span> {{ date('h:i a', strtotime($booking->booking_time)) }}</p>
         </div>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
          <div class="text-center">
            <a href="{{ route('home') }}" class="btn-design-first">Go Back Home</a>
          </div>
        </div>
      </div>

      {{--
    <!-- <div class="row justify-content-center">
      <div class="col-md-8 white-shadow-box">
     <div class="homepbanner-content text-center">
      <h2>Thank You </h2>
      <p>Your Booking is Scheduled</p>
      <a href="{{ route('consultations.upcoming') }}" class="btn-banner-design">Check Bookings</a>
     </div>
      </div>

    </div> -->
    --}}
  </div>
 </section>
@endsection