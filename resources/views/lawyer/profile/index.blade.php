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
</script>
@endsection