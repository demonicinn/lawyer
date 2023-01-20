@extends('layouts.app')
@section('content')
<section class="dashboard_profile-sec min-height-100vh admin_state_bar_table">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>
        
        @livewire('admin.state-bar')

    </div>
</section>
@endsection