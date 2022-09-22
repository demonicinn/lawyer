@extends('layouts.app')
@section('content')
<section class="user_saved-lawyers-sec">
      <div class="container">
         <div class="heading-paragraph-design text-center position-relative mb-4">
            <h2>{{ @$title['title'] }}</h2>
        </div>
        
        @livewire('user.saved-lawyers')

    </div>
</section>


@endsection