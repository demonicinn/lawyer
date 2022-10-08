@extends('layouts.app')
@section('content')
<section class="lawyer_conultation-wrapper-sec">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
        </div>

        <div>
            <div class="lawyer_conultation-wrapper">
                <div class="tabs_design-wrap three_tabs-layout">

                    @include('pages.consultations.tabs')

                    <div class="lawyer-tabs_contents">
                        <div class="tab-content">
                            <div id="Upcoming" class="container tab-pane active">

                                <div class="table-responsive table-design">
                                    <table style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Practice Area</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $role = 'user';
                                            if(Auth::user()->role == 'user'){
                                            $role = 'lawyer';
                                            }
                                            @endphp
                                            @forelse ($upcomingConsultations as $upcoming)

                                            @php
                                            $start_time=date('g:i A', strtotime($upcoming->booking_time));
                                            $end_time=date('g:i A', strtotime($upcoming->booking_time. ' +30 minutes'));
                                            @endphp
                                            <tr>
                                                <td>{{$upcoming->$role->first_name}}</td>
                                                <td>{{$upcoming->$role->last_name}}</td>
                                                <td>Car Accident</td>
                                                <td>{{date('d-m-y', strtotime($upcoming->booking_date)) }}</td>
                                                <td>{{$start_time}} - {{$end_time}}</td>
                                                <td>
                                                    <div class="dropdown reshedule_dropdowns">
                                                        <button class="toggle_cstm-btn" type="button">Reshedule</button>

                                                        @if (Auth::user()->role == 'user')

                                                        <div class="reshedule_wrap-box">
                                                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                            <p>Resheduling consultation will hurt your ratings</p>
                                                            <div class="d-flex">
                                                                <a href="{{route('reschedule.booking',$upcoming->id)}}" class="accept_btn showModal">Confirm</a>

                                                                <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                            </div>
                                                        </div>

                                                        @else

                                                        <div class="reshedule_wrap-box">
                                                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                            <p>Resheduling consultation will hurt your ratings</p>
                                                            <div class="d-flex">
                                                                <a href="{{route('reschedule.booking',$upcoming->id)}}" class="accept_btn showModal">Confirm</a>

                                                                <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                            </div>
                                                        </div>

                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @empty
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-center pt-3">
                                                    <h4>No consultations found</h4>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection