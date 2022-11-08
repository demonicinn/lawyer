@extends('layouts.app')
@section('content')

<section class="body-banner support_main--sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>Support</h2>
        </div>
        <div class="support-wrapper_divs">
            <form class="form-design" method="post" action="{{route('support.store')}}">
                @csrf
                <div class="white-shadow-box create_profile-full-container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>First Name</label>
                                <input class="@error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{auth()->user()->first_name}}" placeholder="First Name">
                                @error('first_name')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>Last Name</label>
                                <input class="@error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{auth()->user()->last_name}}" placeholder="Last Name">
                                @error('last_name')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>Email</label>
                                <input class="@error('email') is-invalid @enderror" type="email" name="email" value="{{auth()->user()->email}}" placeholder="Email">
                                @error('email')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph select-design select-design-2">
                                <label>Reason</label>
                                <select name="reason" class="@error('reason') is-invalid @enderror">
                                    <option value="" disabled selected>Select reason</option>
                                    <option>Issue with lawyer </option>
                                    <option>Issue with client</option>
                                    <option>Issue with website</option>
                                    <option>Issue with account </option>
                                    <option>Request new feature </option>
                                    <option>Other</option>
                                </select>
                                @error('reason')<div class="help-block">{{ $message }}</div>@enderror
                            </div>

                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph textarea-design">
                                <label>Message</label>
                                <textarea class="@error('message') is-invalid @enderror" name="message" style="height: 150px;" placeholder="Message"></textarea>
                                @error('message')<div class="help-block">{{ $message }}</div>@enderror
                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-group justify-content-center row mt-3">

                    <div class="col-md-6"> {!! htmlFormSnippet() !!} </div>

                </div>
                @error('g-recaptcha-response')
                <span class="invalid-feedback" role="alert">
                    <strong>ReCaptcha field is required</strong>
                </span>
                @enderror
                <div class="row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                        <div class="form-grouph submit-design text-center">
                            <input type="submit" value="Submit" class="btn-design-second">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@section('script')
<style>
    .invalid-feedback {
        display: block;
        text-align: center;
        display: inline-block;
    }
</style>
@endsection