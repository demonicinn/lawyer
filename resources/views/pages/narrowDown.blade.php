@extends('layouts.app')
@section('content')
<section class="body-banner narrow-down-cand-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center">
            <h2>Select the type of contract...</h2>
            <p>Check the box that best describes your needs.</p>
        </div>
        <div class="narrow-down-rows">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="narrow-box position-relative    ">
                        <div class="narrow-icon-box">
                            <img src="assets/images/litigations.svg">
                        </div>
                        <h4>Litigation</h4>
                        <p>Argue on your behalf in court or in front of an arbitrator</p>
                        <a class="link-overlay" href="{{ route('narrow.litigations') }}"></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="narrow-box position-relative">
                        <div class="narrow-icon-box">
                            <img src="assets/images/contracts.svg">
                        </div>
                        <h4>Contracts</h4>
                        <p>Draft or review personal, business, or real estate contracts</p>
                        <a class="link-overlay" href="{{ route('narrow.contracts') }}"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="still-not-sure text-center">
            <p>Still not sure? Read our detailed explanation <a class="pa-design" href="#">here.</a></p>
        </div>
    </div>
</section>
@endsection