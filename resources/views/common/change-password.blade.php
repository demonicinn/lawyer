@extends('layouts.app')
@section('content')


<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        <div class="user_acc_info-wrapper">
            <form class="form-design" method="post" action="{{route('update.password')}}" enctype="multipart/form-data">
                @csrf
                <div class="white-shadow-scnd-box">
                    <div class="form">
                        <div class="form-grouph input-design">
                            <label>Old Password*</label>
                            <input class="@error('old_password') is-invalid @enderror" type="password" name="old_password">
                            @error('old_password')<div class="help-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-grouph input-design">
                            <label>New Password*</label>
                            <input class="@error('password') is-invalid @enderror" type="password" name="password">
                            @error('password')<div class="help-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-grouph input-design">
                            <label>Confirm Password*</label>
                            <input class="@error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation">
                            @error('password_confirmation')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                        <div class="form-grouph submit-design text-center">
                            <input type="submit" value="Update" class="btn-design-second">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection