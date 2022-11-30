@extends('layouts.app')
@section('content')
<section class="lawyer-services-sec">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
            <h2>Lawyers that provide<br> these services</h2>
            <a href="{{ route($route) }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Practice Area</a>
        </div>
        
        @livewire('search-lawyers')

    </div>
</section>
@endsection


@section('script')
{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/price_range_style.css') }}">
<script src="{{ asset('assets/js/price_range_script.js') }}"></script>
--}}

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">







<style>
    .slider-box {width: 90%; margin: 25px auto}
label, input {border: none; display: inline-block; margin-right: -4px; vertical-align: top; width: 30%}
input {width: 70%}
.slider {margin: 25px 0}
</style>









<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.css">


<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.0/nouislider.min.js"></script>
<script>








</script>
@endsection