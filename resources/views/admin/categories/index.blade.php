@extends('layouts.app')
@section('content')
<section class="min-height-100vh admin_categories_table">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>
        
        @livewire('admin.categories')

    </div>
</section>
@endsection


@section('script')
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
@endsection