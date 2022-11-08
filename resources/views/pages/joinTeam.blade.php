@extends('layouts.app')
@section('content')

<section class="body-banner support_main--sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>Join the Team</h2>
        </div>
        <div class="support-wrapper_divs">
            <form class="form-design" method="post" action="{{route('joinTeamStore')}}" enctype="multipart/form-data">
                @csrf
                <div class="white-shadow-box create_profile-full-container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>Name</label>
                                <input class="@error('name') is-invalid @enderror" type="text" name="name" placeholder="Name">
                                @error('name')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>Email</label>
                                <input class="@error('email') is-invalid @enderror" type="email" name="email" placeholder="Email">
                                @error('email')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-grouph input-design">
                                <label>Resume</label>
                                <input class="@error('resume') is-invalid @enderror" type="file" name="resume" placeholder="Resume">
                                @error('resume')<div class="help-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        
                    </div>
                </div>

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