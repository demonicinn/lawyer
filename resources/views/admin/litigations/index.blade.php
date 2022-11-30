@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <!--<h2>{{ @$title['title'] }}</h2>-->
            <h2>Litigation Practice Areas</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>
        
        @livewire('admin.litigations')

    </div>
</section>
@endsection