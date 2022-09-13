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
                Your account is created successfully, we will review your account details and will inform you on account approval status soon
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
        <div class="layout layout_0id0">
            <div class="grey-light-heading">
                <h4>0itemTitle0</h4>
            </div>
            <div class="form-flex">
                <div class="form-grouph input-design">
                    <label for="bar_number" class="form-label">Bar Number*</label>
                    <input maxlength="20" required="required" name="lawyer_address[0key0][data][0key1][bar_number]" type="text" value="0bar0">
                    
                </div>
                <div class="form-grouph input-design">
                    <label for="year_admitted" class="form-label">Year Admitted*</label>
                    <input maxlength="4" required="required" name="lawyer_address[0key0][data][0key1][year_admitted]" type="text" value="0year0">
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
        callAdmission();
    });

    function callAdmission(){

        let newHtml = '';
        var html = $('.layoutHtml').html();

        $.each($('.multiBoxes').find(":selected"), function (i, item) { 
            let id = $(item).attr("data-cat");
            let itemId = $(item).attr("value");
            let name = $(item).attr("data-name");
            let year = $(item).attr("data-year");
            let bar = $(item).attr("data-bar");

            //console.log(item)
            //console.log('year', year)
            //console.log('bar', bar)

            //...
            let html1 = html.replace(/0key0/g, id);
            html1 = html1.replace(/0id0/g, id);
            html1 = html1.replace(/0key1/g, itemId);
            html1 = html1.replace(/0itemTitle0/g, name);
            html1 = html1.replace(/0year0/g, year ?? '');
            html1 = html1.replace(/0bar0/g, bar ?? '');

            newHtml += html1;
        });

        //...
        $('.admissionHtml').html(newHtml);

    }
    //...
    callAdmission();

</script>
@endsection