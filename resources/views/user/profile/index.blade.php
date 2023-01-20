@extends('layouts.app')
@section('content')
<section class="body-banner user_account-info-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        <div class="user_acc_info-wrapper">
            {!! Form::open(['route' => 'user.profile.update', 'class'=>' form-design']) !!}
            <div class="white-shadow-scnd-box">
                <div class="form-flex">
                    <div class="form-grouph input-design{!! ($errors->has('first_name') ? ' has-error' : '') !!}">
                        {!! Form::label('first_name','First Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('first_name', $user->first_name ?? null, ['placeholder'=>'First Name', 'class' => ($errors->has('first_name') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-grouph input-design{!! ($errors->has('last_name') ? ' has-error' : '') !!}">
                        {!! Form::label('last_name','Last Name*', ['class' => 'form-label']) !!}
                        {!! Form::text('last_name', $user->last_name ?? null, ['placeholder'=>'Last Name', 'class' => ($errors->has('last_name') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                    </div>
                 
                    <div class="form-grouph input-design{!! ($errors->has('email') ? ' has-error' : '') !!}">
                        {!! Form::label('email','Email*', ['class' => 'form-label']) !!}
                        {!! Form::email('email', $user->email ?? null, ['placeholder'=>'Email', 'class' => ($errors->has('email') ? ' is-invalid' : ''), 'disabled']) !!}
                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                    </div>
                   
                    <div class="form-grouph input-design{!! ($errors->has('contact_number') ? ' has-error' : '') !!}">
                        {!! Form::label('contact_number','Phone*', ['class' => 'form-label']) !!}
                        {!! Form::text('contact_number', $user->contact_number ?? null, ['placeholder'=>'Phone', 'class' => 'phone '.($errors->has('contact_number') ? ' is-invalid' : '')]) !!}
                        {!! $errors->first('contact_number', '<span class="help-block">:message</span>') !!}
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
            {!! Form::close() !!}
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<script>
$('.phone').inputmask('(999)-999-9999');

</script>
@endsection

