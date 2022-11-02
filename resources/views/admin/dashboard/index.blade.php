@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Dashboard</h2>
        </div>
        <div class="dashboard_wrapper">

            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.lawyers.index') }}">
                            <h4>LAWYERS <br>AVAILABLE</h4>
                            <h2 class="number-value">{{$lawyers}}</h2>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                 
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.users.index') }}">
                            <h4>CLIENTS <br>AVAILABLE</h4>
                            <h2 class="number-value">{{$clients}}</h2>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.litigations.index') }}">
                            <h4>LITIGATIONS</h4>
                            <h2 class="number-value">{{$litigations}}</h2>
                            <span class="three_dots">...</span>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.contracts.index') }}">
                            <h4>CONTRACTS</h4>
                            <h2 class="number-value">{{$contracts}}</h2>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.states.index') }}">
                            <h4>STATES</h4>
                            {{--<h2 class="number-value">{{$states}}</h2>--}}
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.subscriptions.index') }}">
                            <h4>SUBSCRIPTIONS</h4>
                            {{--<h2 class="number-value">{{$subscriptions}}</h2>--}}
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>

                {{--
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.categories.index') }}">
                            <h4>CATEGORIES</h4>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>
                --}}

                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.categories.index') }}">
                            <h4>Federal Court</h4>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.state_bar.index') }}">
                            <h4>State Bar</h4>
                        </a>
                        <span class="three_dots">...</span>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="#">Upcoming Consultations</a>
                            <p>{{ $upcomingConsultations }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="#">Completed Consultations</a>
                            <p>{{ $completeConsultations }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="#">Accepted Consultations</a>
                            <p>{{ $acceptedConsultations }}</p>
                        </div>
                    </div>
                </div>
            </div>
</section>
@endsection