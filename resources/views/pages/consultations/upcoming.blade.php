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
                    <div class="lawyer-tabs_lists">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link{{ request()->routeIs('consultations.upcoming') ? ' active' : '' }}" href="{{ route('consultations.upcoming') }}">Upcoming</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->routeIs('consultations.complete') ? ' active' : '' }}" href="{{route('consultations.complete')}}">Complete</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link{{ request()->routeIs('consultations.accepted') ? ' active' : '' }}" href="{{route('consultations.accepted')}}">Accepted</a>
                            </li>
                        </ul>
                    </div>


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
                                            <tr>
                                                <td>{{$upcoming->$role->first_name}}</td>
                                                <td>{{$upcoming->$role->last_name}}</td>
                                                <td>Car Accident</td>
                                                <td>{{date('d-m-y', strtotime($upcoming->booking_date)) }}</td>
                                                <td>{{date('g:i A', strtotime($upcoming->booking_time))}} - {{date('g:i A', strtotime($upcoming->booking_time. ' +30 minutes'))}} </td>
                                                <td>
                                                    <div class="dropdown reshedule_dropdowns">
                                                        <button class="toggle_cstm-btn" type="button">Reshedule</button>

                                                        @if (Auth::user()->role == 'user')

                                                        <div class="reshedule_wrap-box">
                                                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                            <p>Resheduling consultation will hurt your ratings</p>
                                                            <div class="d-flex">
                                                                <a href="{{route('user.reschedule.booking',$upcoming->id)}}" class="accept_btn showModal">Confirm</a>

                                                                <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                            </div>
                                                        </div>
                                                        
                                                            @else

                                                            <div class="reshedule_wrap-box">
                                                                <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                                <p>Resheduling consultation will hurt your ratings</p>
                                                                <div class="d-flex">
                                                                    <form method="post" action="{{route('reshedule.consultation',$upcoming->id )}}">
                                                                        @csrf
                                                                        <button type="submit" class="confirm_dropdown-btn">Confirm</button>
                                                                    </form>
                                                                    <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                                </div>
                                                            </div>

                                                            @endif



                                                    </div>
                                                </td>
                                            </tr>
                                            @empty

                                            <h2>No Upcoming Consultation.</h2>

                                            @endforelse
                                        </tbody>
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