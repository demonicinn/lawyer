@extends('layouts.app')
@section('content')
<section class="body-banner min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        
        @livewire('lawyer.leaves')

    </div>
</section>
@endsection