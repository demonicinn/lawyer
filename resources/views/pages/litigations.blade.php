@extends('layouts.app')
@section('content')
<section class="body-banner narrow-down-inner-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
            <h2>Select a practice area…</h2>
            <p>Check the box that best describes your needs.</p>
            <a href="{{ route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Go Back</a>
        </div>
        <div class="narrow-selection-box">
            {!! Form::open(['route' => 'lawyers', 'method'=>'get', 'class'=>'form-design']) !!}

                <div class="white-shadow-box">
                    
                    {{--
                    <div class="form-flex">
                        @foreach ($litigations as $litigation)
                        <div class="form-grouph checkbox-design position-relative">
                            <input type="radio" name="litigations[]" value="{{ $litigation->id }}">
                            <button class="checkbox-btn"></button>
                            <label>{{ $litigation->name }}</label>
                        </div>
                        @endforeach

                    </div>
                    --}}
                    
                    @php
                        $count = count($litigations) / 2;
                        $count = number_format($count);
                    @endphp
                    <div class="row">
                        @foreach ($litigations->chunk($count) as $chunk)
                        <div class="col-md-6">
                            @foreach ($chunk as $litigation)
                            <div class="form-grouph checkbox-design position-relative">
                                <input type="radio" name="litigations[]" value="{{ $litigation->id }}">
                                <button class="checkbox-btn"></button>
                                <label>{{ $litigation->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        
                    </div>
                </div>
                
                {!! $errors->first('litigations', '<span class="help-block">:message</span>') !!}


                <input type="hidden" name="latitude">
                <input type="hidden" name="longitude">
                <input type="hidden" name="type" value="litigation">
                
                <div class="form-confim-div">
                    <div class="form-grouph submit-design text-center">
                        <button class="btn-design-first" type="submit">{{__ ('Confirm') }}</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection