@extends('layouts.app')
@section('content')
<section class="body-banner narrow-down-inner-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
            <h2>Can you narrow down even further…</h2>
            <p>Check one of the Contracts that may apply.</p>
            <a href="{{ url()->previous() }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Go Back</a>
        </div>
        <div class="narrow-selection-box">
            <form class="form-design">
                <div class="white-shadow-box">
                    <div class="form-flex">

                        @foreach ($contracts as $contract)
                        <div class="form-grouph checkbox-design position-relative">
                            <input type="checkbox" name="narrow-litigations">
                            <button class="checkbox-btn"></button>
                            <label>{{$contract->name}}</label>
                        </div>
                        @endforeach
                        
                </div>
                <div class="form-confim-div">
                    <div class="form-grouph submit-design text-center">
                        <a href="lawyer-service-providing.html" class="btn-design-first">Confirm</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection