@extends('layouts.app')
@section('content')
<section class="body-banner portal-inner-page-sec">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>


        <div class="">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.upcoming') }}">Consultations</a>
                            <p>{{ $upcomingConsultations }}</p>
                        </div>
                        <span class="three_dots">...</span>
                    </div>
                </div>

                <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div>
                        <div class="portal-cntnt-wrapper">
                            <a href="#">Dashboard</a>
                            <p></p>
                        </div>
                        <span class="three_dots">...</span>
                    </div>
                </div> -->

            {{--    
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.complete') }}">Account</a>
                            <p>{{ $completeConsultations }}</p>
                        </div>
                        <span class="three_dots">...</span>
                    </div>
                </div>
            --}}

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('lawyer.profile') }}">Account</a>
                            <p></p>
                        </div>
                        <span class="three_dots">...</span>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{route('support')}}">Support</a>
                            <p></p>
                        </div>
                        <span class="three_dots">...</span>
                    </div>
                </div>

            </div>


            {!! Form::open(['method'=>'get']) !!}
            <div class="row py-4">
                <div class="col-md-2 form-group">
                    <input type="number" class="form-control" name="year" value="{{ $year = request()->year ?? date('Y') }}" min="2022" max="{{ date('Y') }}" required>
                </div>

                <div class="col-md-1 form-group">
                    <button class="btn btn-primary" style="background-color: #f93f64; border-color:#f93f64;" type="submit">Search</button>
                </div>

            </div>
            {!! Form::close() !!}


           <div class="row">
            <div id="bookingChart" class="col-md-6"></div>
           </div>
        </div>


    </div>
</section>
@endsection


@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css"
rel="Stylesheet"type="text/css"/>



<script type="text/javascript">
    // Load google charts
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(bookingChart);

    @php
    $months=array('01'=>'JAN', '02'=>'FEB', '03'=>'MAR', '04'=>'APR', '05'=>'MAY', '06'=>'JUN', '07'=>'JUL', '08'=>'AUG', '09'=>'SEP', '10'=>'OCT', '11'=>'NOV', '12'=>'DEC');
    @endphp


    function bookingChart() {
        
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Months');
        data.addColumn('number', 'Bookings by Months');
        
        data.addRows([
        @foreach($months as $k => $month)
            ['{{ $month }}', {{ getBookingsCount($k, $year) }}],
        @endforeach
        ]);

        
        var options = {
            hAxis: {
                title: ''
            },
            vAxis: {
                title: ''
            },
            seriesType: 'bars',
            series: {1: {type: 'line'}},
            tooltip: { isHtml: true },
            legend: { position: 'top' },
            colors: ['#f93f64'],
            chartArea: {'width': '85%'},
            border: '1px solid #979797',
            is3D: true,
            backgroundColor: {
                'fill': '#f8f8f8',
                'stroke': '#979797',
                'strokeWidth': '1',
            },
        };
        
        var chart = new google.visualization.ComboChart(document.getElementById('bookingChart'));
        chart.draw(data, options);
    }


</script>
@endsection