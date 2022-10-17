@extends('layouts.app')
@section('content')


<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>
        <div class="user_acc_info-wrapper">
            <form class="form-design" method="post" action="{{route('admin.profile.update')}}" enctype="multipart/form-data">
                @csrf
                <div class="white-shadow-scnd-box">
                    <div class="lawyer_profile-img mb-3">
                        <div class="circle" id="uploaded">
                            <img class="profile-pic" src="{{ $user->profile_pic }}">
                        </div>
                        <div class="p-image">
                            <span class="pencil_icon"><i class="fa-solid fa-pencil upload-button"></i></span>
                            <input class="file-upload" id="upload" type="file" accept="image/*" />
                            <input type="hidden" name="image" id="upload-img" />
                        </div>
                    </div>
                    <div class="form-flex">


                        <div class="form-grouph input-design">
                            <label>First Name*</label>
                            <input class="@error('first_name') is-invalid @enderror" type="text" name="first_name" value="{{$user->first_name}}" placeholder="First Name">
                            @error('first_name')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-grouph input-design">
                            <label>Last Name*</label>
                            <input class="@error('last_name') is-invalid @enderror" type="text" name="last_name" value="{{$user->last_name}}" placeholder="Last Name">
                            @error('last_name')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-grouph input-design">
                            <label>Email*</label>
                            <input class="@error('email') is-invalid @enderror" disabled type="email" name="email" value="{{$user->email}}" placeholder="Email">
                            @error('email')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-grouph input-design">
                            <label>Phone</label>
                            <input class="@error('contact_number') is-invalid @enderror" type="number" name="contact_number" value="{{$user->contact_number}}" placeholder="Phone">
                            @error('contact_number')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                        <!-- <div class="form-grouph input-design">
                            <a href="{{route('change.password')}}">
                                Click to change password
                            </a>
                        </div> -->
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
@section('script')
@include('common.crop_image')
@endsection