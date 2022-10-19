@extends('layouts.app')
@section('content')
<section class="about-banner-sec " style="background-image: url('{{ asset('assets/images/home-banner.png') }}');">
  <div class="container">
     <div class="homepbanner-content text-center">
      <h2>Thank You</h2>
      <p>Your Booking is Scheduled</p>
      <a href="{{ route('consultations.upcoming') }}" class="btn-banner-design">Check Bookings</a>
     </div>
  </div>
 </section>
@endsection