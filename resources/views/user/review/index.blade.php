@extends('layouts.app')
@section('content')
<section class="body-banner user_account-info-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        <div class="user_acc_info-wrapper">


            

            {!! Form::open(['route' => ['review.store', encrypt($booking->id)], 'class'=>' form-design']) !!}
            <div class="white-shadow-scnd-box">
                <div class="form-flex">

                    <div class="col-md-6">
                        <div class="list-item list-service-item">
                            <div class="lawyer-hire-block">
                                <div class="lawyers-img-block">
                                    <img src="{{ $booking->lawyer->profile_pic }}">
                                </div>
                                <div class="lawyers-service-cntnt-block">
                                    <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                        <h4 class="lawyer-name">{{ $booking->lawyer->name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-grouph input-design{!! ($errors->has('rating') ? ' has-error' : '') !!}">
                            {!! Form::label('rating', 'Did the lawyer show up to the consultation', ['class' => 'form-label']) !!}
                            <div id="rateYo"></div>
                            <input type="hidden" name="rating" value="">
                            {!! $errors->first('rating', '<span class="help-block">:message</span>') !!}
                        </div>

                        <div class="form-grouph input-design{!! ($errors->has('comment') ? ' has-error' : '') !!}">
                            {!! Form::label('comment', 'Comment', ['class' => 'form-label']) !!}
                            {!! Form::textarea('comment', null, ['placeholder'=>'Leave Comment', 'class' => ($errors->has('comment') ? ' is-invalid' : '')]) !!}
                            {!! $errors->first('comment', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <div class="form-grouph submit-design text-center">
                        <button type="submit" class="btn-design-second">Submit</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

<script>
    $(document).ready(function() {
        $("#rateYo").rateYo({
            starWidth: "40px",
            onSet: function (rating, rateYoInstance) {
                $('input[name=rating]').val(rating);
            }
        });
    });
</script>
@endsection