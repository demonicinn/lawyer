@extends('layouts.app')
@section('content')
<section class="body-banner portal-inner-page-sec">
    <div class="container lwyer_dashbord">
        <div class="heading-paragraph-design text-center position-relative mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>


        {{--
        <div class="dashboard_wrapper">
           <div class="row">
             <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <div class="data-white-box position-relative">
                <div class="data-content-box">
                <a href="{{ route('consultations.upcoming') }}">
                    <h4>UPCOMING CONSULTATIONS</h4>
                </a>
                <h2 class="number-value">{{ $upcomingConsultations }}</h2>
                </div>
              </div>
             </div>
             <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <div class="data-white-box position-relative">
                <div class="data-content-box">
                <a href="{{ route('consultations.complete') }}">
                <h4>COMPLETED CONSULTATIONS</h4>
                </a>
                <h2 class="number-value">{{ $completeConsultations }}</h2>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <div class="data-white-box position-relative">
                <div class="data-content-box">
                <a href="{{ route('consultations.accepted') }}">
                <h4>Accepted  <br>CASES</h4>
                </a>
                <h2 class="number-value">1,586</h2>
                </div>
              </div>
            </div>
           </div>
        </div>
        --}}




        <div class="">
            <div class="row ">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.upcoming') }}">UPCOMING CONSULTATIONS</a>
                            <p class="number-value">{{ $upcomingConsultations }}</p>
                        </div>
                    </div>
                </div>
           
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.complete') }}">COMPLETED CONSULTATIONS</a>
                            <p class="number-value">{{ $completeConsultations }}</p>
                        </div>
                    </div>
                </div>         

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                    <div class="portal-div-design position-relative">
                        <!-- <div class="portal-div-img">
                            <img src="{{ asset('assets/images/schedule.svg') }}">
                        </div> -->
                        <div class="portal-cntnt-wrapper">
                            <a href="{{ route('consultations.accepted') }}">ACCEPTED CASES</a>
                            <p class="number-value">{{ $acceptedConsultations }}</p>
                        </div>
                    </div>
                </div>

              {{--     <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
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
                </div>   --}}

            </div>

           <div class="row">
            <div class="col-md-12">
            <div class="data-white-box no-hover-box">
            <div class="heading-design-flex d-flex justify-content-spacebw align-items-center">
                  <h4>BOOKINGS PER MONTH</h4>
                  {!! Form::open(['method'=>'get']) !!}
            <div class="form-char-flext">
                <div class="form-group input-design">
                    <input type="number" class="form-control" name="year" value="{{ $year = request()->year ?? date('Y') }}" min="2022" max="{{ date('Y') }}" required>
                </div>
                <div class="form-group submit-design">
                    <button class="btn btn-primary" style="background-color: #f93f64; border-color:#f93f64;" type="submit">Search</button>
                </div>
            </div>
            {!! Form::close() !!}
                </div>
            <div id="bookingChart"></div>
            </div>
            </div>
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
        data.addColumn('number', 'BOOKINGS PER MONTH');
        
        data.addRows([
        @foreach($months as $k => $month)
            ['{{ $month }}', {{ getBookingsCount($k, $year) }}],
        @endforeach
        ]);

        
        var options = {
            hAxis: {
                title: '',
                gridlines: {
                  color: 'transparent'
                },
                textStyle: {
            fontSize: 10,
            color: '#979797'
            }
            },
            vAxis: {
                title: '',
                gridlines: {
                  color: 'transparent'
                },
                textStyle: {
            fontSize: 10,
            color: '#979797'
            }
            },
            seriesType: 'bars',
            series: {1: {type: 'line'}},
            tooltip: { isHtml: true },
            legend: { position: 'none' },
            colors: ['#f93f64'],
            chartArea: {'width': '85%'},
            is3D: true,
            backgroundColor: {
                'fill': 'transparent',
                'stroke': 'transparent',
                'strokeWidth': '0',
            },
            annotations: {
            textStyle: {
            fontSize: 10,
            color: '#979797'
            }
        }
        };
        
        var chart = new google.visualization.ComboChart(document.getElementById('bookingChart'));
        chart.draw(data, options);
    }


</script>
@endsection