@extends('layouts.app')
@section('content')
<section class="body-banner lawyer_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <!-- <h2>{{ @$title['title'] }}</h2> -->
            <h2>Account Information</h2>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<script>
$('.phone').inputmask('(999)-999-9999');

</script>
<div class="layoutHtml" style="display: none;">
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


<div class="stateHtmlDom" style="display: none;">
    <div>
        <div class="layout layout_0id0">
            <div class="grey-light-heading">
                <h4>0itemTitle0</h4>
            </div>
            <div class="form-flex">
                <div class="form-grouph input-design">
                    <label for="bar_number" class="form-label">Bar Number*</label>
                    <input maxlength="20" required="required" name="lawyer_state[0key0][bar_number]" type="text" value="0bar0">
                    
                </div>
                <div class="form-grouph input-design">
                    <label for="year_admitted" class="form-label">Year Admitted*</label>
                    <input maxlength="4" required="required" name="lawyer_state[0key0][year_admitted]" type="text" value="0year0">
                </div>
            </div>
        </div>
    </div>
</div>



@php
$getTime = \App\Models\User::getTime();
@endphp
<div class="layoutHours" style="display: none;">
    <div class="appned_inputs">
        <div class="form-flex layout layout_0key0">
            <div class="form-grouph input-design{!! ($errors->has('from_time') ? ' has-error' : '') !!}">
                {!! Form::select('day[0day0][data][0key0][from_time]', $getTime, null, ['class' => ($errors->has('from_time') ? ' is-invalid' : '')]) !!}
                {!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-grouph input-design{!! ($errors->has('to_time') ? ' has-error' : '') !!}">
                {!! Form::select('day[0day0][data][0key0][to_time]', $getTime, null, ['class' => ($errors->has('to_time') ? ' is-invalid' : '')]) !!}
                {!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
            </div>
              <span class="btn_close">X</span>
        </div>

    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}"></script>


<script>
    $('input[name=is_consultation_fee]').on('click', function() {
        let fee = $(this).val();
        $('#consultation_fee').attr('disabled', 'disabled');

        if (fee == 'yes') {
            $('#consultation_fee').removeAttr('disabled');
        }
    });

    @if(@$user->details->is_consultation_fee == 'no')
    $('#consultation_fee').removeAttr('disabled');
    @endif



    $(".hoursDay").on('click', function() {
        let value = $(this).val();
        $('.' + value).hide();

        if ($(this).is(":checked")) {
            $('.' + value).show();
        }
    })

    //multiBoxes
    $('#mcategory').on('change', function (){
        ///let id = $(this).attr("data-cat");
        //$('.admissionHtml.cat_'+id).html("");
        
        callAdmission();
    });

    function callAdmission(){

        let newHtml = '';
        var html = $('.layoutHtml').html();

        $.each($('#mcategory').find(":selected"), function (i, item) { 
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
        $('.admissionHtml.cat').html(newHtml);

    }
    //...
    callAdmission();


    //...state bar
    //stateHtml
    $('#mstate').on('change', function (){        
        callStateAdmission();
    });

    function callStateAdmission(){

        let newHtmlState = '';
        var html = $('.stateHtmlDom').html();

        $.each($('#mstate').find(":selected"), function (i, item) { 
            let id = $(item).attr("value");
            let name = $(item).attr("data-name");
            let year = $(item).attr("data-year");
            let bar = $(item).attr("data-bar");

            //...
            let html1 = html.replace(/0key0/g, id);
            html1 = html1.replace(/0id0/g, id);
            html1 = html1.replace(/0itemTitle0/g, name);
            html1 = html1.replace(/0year0/g, year ?? '');
            html1 = html1.replace(/0bar0/g, bar ?? '');

            newHtmlState += html1;
        });
        
        //...
        $('.stateHtml.cat').html(newHtmlState);

    }
    //...
    callStateAdmission();


    $('.clickHours').on('click', function (){
        let day = $(this).attr('data-day');
        layoutHoursBind(day);
    });

    function layoutHoursBind(day){

        var countHour = $('.addNewHoursLayout.'+day+' .layout').length;
        countHour = countHour + 1;
        
        var html = $('.layoutHours').html();
        //...
        html = html.replace(/0key0/g, countHour);
        html = html.replace(/0day0/g, day);


        //...
        $('.addNewHoursLayout.'+day).append(html);

    }

    $('.deleteLayout').on('click', function (){
        let day = $(this).attr('data-day');
        let id = $(this).attr('data-id');

        //...

        $('.addNewHoursLayout.'+day+' .layout-'+id+' .delete').val('yes');
        $('.addNewHoursLayout.'+day+' .layout-'+id).hide();
    });

    $(document).ready(function() {
        @foreach ($categoriesMulti as $category)
        $('#ccat-{{$category->id}}').select2({
            placeholder: "Please select {{ $category->name }}",
            allowClear: true
        });
        @endforeach
    });
    
    
    var geocoder = new google.maps.Geocoder();
    $(document).on('change', '#zip_code', function(){
        var zipcode = $(this).val();
        var country = "United States";
		//console.log(zipcode)
        

        //...

        geocoder.geocode({ 'address': zipcode + ',' + country }, function (result, status) {

            var stateName = '';
            var cityName = '';

            var addressComponent = result[0]['address_components'];

            // find state data
            var stateQueryable = $.grep(addressComponent, function (x) {
                return $.inArray('administrative_area_level_1', x.types) != -1;
            });

            if (stateQueryable.length) {
                stateName = stateQueryable[0]['long_name'];

                var cityQueryable = $.grep(addressComponent, function (x) {
                    return $.inArray('locality', x.types) != -1;
                });

                // find city data
                if (cityQueryable.length) {
                    cityName = cityQueryable[0]['long_name'];
                    
                    $('#city').val(cityName);
                }
                 
                if (stateName.length) {
					$("#states_id option:contains("+stateName+")").attr('selected', 'selected');
				}
                //console.log('stateName', stateName)
                //console.log('cityName', cityName)
        
            }
        });


        
    });
    
</script>
@endsection