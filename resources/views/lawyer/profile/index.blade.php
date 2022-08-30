@extends('layouts.app')
@section('content')
<section class="body-banner lawyer_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>

        @if(@$user->details && $user->details->is_verified=='no')
        @php
        $details = $user->details;
        $hoursCount = $user->lawyerHours->count();
        $litigationsCount = $user->lawyerLitigations->count();
        $contractsCount = $user->lawyerContracts->count();
        @endphp
        <div class="lawyer_profile-wrapper">

            @if($details->review_request=='1')
            <div class="alert alert-info">
                Your Profile under Review.
            </div>
            @endif

            @if($details->is_admin_review=='2' && $details->review_request=='0')
            <div class="alert alert-warning">
                Your Profile is Declined.
            </div>
            @endif

            @if($details->address && $details->review_request=='0' && $hoursCount > 0 && ($litigationsCount > 0 || $contractsCount > 0))
            <div class="alert alert-success">
                Submit Your Profile for Review <a href="{{ route('lawyer.profile.submit') }}" onclick="event.preventDefault(); document.getElementById('profile-submit-form').submit();" class="btn btn-sm btn-success">Submit</a>
            </div>
            <form id="profile-submit-form" action="{{ route('lawyer.profile.submit') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endif

        </div>
        @endif

        @include('lawyer.profile.form')

    </div>
</section>
@endsection

@section('script')
@include('common.crop_image')

<div class="layoutHtml">
    <div>
        <div class="layout">
            <div class="grey-light-heading">
                <h4>0itemTitle0</h4>
            </div>
            <div class="form-flex">
                <div class="form-grouph input-design">
                    {!! Form::label('bar_number','Bar Number*', ['class' => 'form-label']) !!}
                    {!! Form::text('lawyer_address[0key0][data][0key1][bar_number]', null, ['maxlength'=>'20', 'required'=>'required']) !!}
                    {!! $errors->first('bar_number', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-grouph input-design">
                    {!! Form::label('year_admitted','Year Admitted*', ['class' => 'form-label']) !!}
                    {!! Form::text('lawyer_address[0key0][data][0key1][year_admitted]', null, ['maxlength'=>'4', 'required'=>'required']) !!}
                    {!! $errors->first('year_admitted', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('input[name=is_consultation_fee]').on('click', function() {
        let fee = $(this).val();
        $('#consultation_fee').hide();

        if (fee == 'yes') {
            $('#consultation_fee').show();
        }
    });

    @if(@$user -> details -> is_consultation_fee == 'no')
    $('#consultation_fee').hide();
    @endif



    $(".hoursDay").on('click', function() {
        let value = $(this).val();
        $('.' + value).hide();

        if ($(this).is(":checked")) {
            $('.' + value).show();
        }
    })

    //multiBoxes
    $('.multiBoxes').on('change', function (){
        let newHtml = '';
        var html = $('.layoutHtml').html();

        $.each($('.multiBoxes').find(":selected"), function (i, item) { 
            let id = $(item).attr("data-cat");
            let itemId = $(item).attr("value");
            let name = $(item).attr("data-name");

            //...
            let html1 = html.replace(/0key0/g, id);
            html1 = html1.replace(/0key1/g, itemId);
            html1 = html1.replace(/0itemTitle0/g, name);

            newHtml += html1;
        });

        //...
        $('.admissionHtml').html(newHtml);

    });


</script>
@endsection