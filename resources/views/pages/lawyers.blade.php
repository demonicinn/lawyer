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