@extends('layouts.app')

@section ('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/datatables.min.css"/>
@endsection

@section('content')
<section class="dashboard_profile-sec min-height-100vh admin_seo_table">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>
        
        @livewire('admin.seo')

    </div>
</section>
@endsection