@extends('layouts.app')
@section('content')
@php
$lawyer = $booking->lawyer;
@endphp
<section class="body-banner user_account-info-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
            <h2>{{ @$title['title'] }}</h2>
            
        </div>
        <div class="user_acc_info-wrapper review-account-wrapper">


            

            {!! Form::open(['route' => ['review.store', encrypt($booking->id)], 'class'=>' form-design']) !!}
            <div class="">
                <div class="form-flex row">

                    <div class="col-md-4 ">
                        <div class="list-item list-service-item white-shadow-scnd-box">
                            <div class="lawyer-hire-block">
                                <div class="lawyers-img-block">
                                    <img src="{{ $lawyer->profile_pic }}">
                                </div>
                                <div class="lawyers-service-cntnt-block">
                                    <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                        <h4 class="lawyer-name text-center">{{ $lawyer->name }}</h4>
                                    </div>
									
									@if(@$lawyer->details->school_attendent)
                                    <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->details->school_attendent }}</p>
                                    @endif
                                    <div class="location_profile-divs school_name border-bottom px-0 pb-2">
                                        <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->details->city }}, {{ @$lawyer->details->states->code }}</address>
                                    </div>
									
									
                                </div>
								
								@if($booking->search_data)
								@php
									$search = json_decode($booking->search_data);
								@endphp
								<div class="practice_area_div px-3">
									<div class="left_trash">
										<span>PRACTICE AREA</span>
										@foreach($search as $id)
											@if($booking->search_type == 'litigations')
											<h5>{{ litigationsData($id) }}</h5>
											@else
											<h5>{{ contractsData($id) }}</h5>
											@endif
										@endforeach
									</div>
								</div>
								@endif
								
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-md-8 ">
                        <div class="white-shadow-scnd-box">
                        <div class="rating-div-design">
                        <div class="form-grouph input-design{!! ($errors->has('rating') ? ' has-error' : '') !!}">
                            <!-- {!! Form::label('rating', 'Did the lawyer show up to the consultation', ['class' => 'form-label']) !!} -->
                            <div id="rateYo"></div>
                            <input type="hidden" name="rating" value="">
                            
                            <div class="show-rating"></div>
                            
                            {!! $errors->first('rating', '<span class="help-block">:message</span>') !!}
                        </div>

                    </div>
                    <div class="form-grouph checkbox-design position-relative clear-both">
                    <input type="checkbox" name="narrow-litigations">
                    <button class="checkbox-btn"></button>
                    <label>Lawyer did not show</label>
                  </div>

                        <div class="textarea-design form-grouph input-design{!! ($errors->has('comment') ? ' has-error' : '') !!}">
                            {!! Form::label('comment', 'Comment', ['class' => 'form-label']) !!}
                            {!! Form::textarea('comment', null, ['placeholder'=>'Leave Comment', 'class' => ($errors->has('comment') ? ' is-invalid' : '')]) !!}
                            {!! $errors->first('comment', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    </div>

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <div class="form-grouph submit-design text-center">
                        <button type="submit" class="btn-design-second">Submit Rating</button>
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
    halfStar: true,
            onSet: function (rating, rateYoInstance) {
                $('input[name=rating]').val(rating);
                $('.show-rating').html('You rated '+rating+' star');
            }
        });
    });
</script>
@endsection