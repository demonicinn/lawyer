@extends('layouts.app')
@section('content')
<section class="body-banner portal-inner-page-sec">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        <div class="">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="portal-div-design position-relative">
                        <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div>
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.upcoming') }}">Upcoming Consultations</a>
                            <p>{{ $upcomingConsultations }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="portal-div-design position-relative">
                        <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div>
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.complete') }}">Completed Consultations</a>
                            <p>{{ $completeConsultations }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    <div class="portal-div-design position-relative">
                        <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div>
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.accepted') }}">Accepted Consultations</a>
                            <p>{{ $acceptedConsultations }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
@endsection