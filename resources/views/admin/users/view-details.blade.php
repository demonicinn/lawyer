@extends('layouts.app')
@section('content')
<section class="body-banner lawyer-directory-profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Client Profile</h2>
            <a href="{{ url()->previous() ?? route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Users</a>
        </div>
    </div>
    <div class="directory-profile-wrapper">
        <form class="directory-form-information form-design">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                    <div class="white-shadow-third-box lawyer-directory_about-block">
                        <div class="form-flex">
                            <div class="form-grouph input-design">
                                {!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
                                {!! Form::text('first_name', $user->first_name ?? null, ['disabled' => true,'class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
                            </div>
                            <div class="form-grouph input-design">
                                {!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
                                {!! Form::text('last_name', $user->last_name ?? null, ['disabled' => true,'class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
                            </div>
                        </div>
                        <div class="form-flex">
                           
                            <div class="form-grouph input-design">
                                {!! Form::label('email','Email*', ['class' => 'form-label']) !!}
                                {!! Form::email('email', $user->email ?? null, ['disabled' => true,'class' => ($errors->has('email') ? ' is-invalid' : '')]) !!}
                            </div>
                            <div class="form-grouph input-design">
                                {!! Form::label('contact_number','Phone*', ['class' => 'form-label']) !!}
                                {!! Form::number('contact_number', $user->contact_number ?? null, ['disabled' => true,'class' => ($errors->has('contact_number') ? ' is-invalid' : '')]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
@endsection