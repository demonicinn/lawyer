@extends('layouts.app')
@section('content')
<section class="body-banner min-height-100vh">
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
                            <div id="Complete" class="container tab-pane fade active show">
                                <div class="table-responsive table-design">
                                    <table style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Practice Area</th>
                                                <th>Date</th>
                                                <th>Details</th>
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
                                            @forelse ($completeConsultations as $complete)
                                            <tr>
                                                <td>{{$complete->$role->first_name}}</td>
                                                <td>{{$complete->$role->last_name}}</td>
                                                <td>Car Accident</td>
                                                <td>{{date('d-m-y', strtotime($complete->booking_date)) }}</td>
                                                <td>
                                                    <a class="view-icon info_icns" href="#"><i class="fas fa-eye"></i></a>

                                                    <div class="info_icns_note_name">
                                                        @if (@$complete->notes->note !=null)
                                                        {{@$complete->notes->note}}

                                                        @endif
                                                    </div>

                                                    @if (!Auth::user()->role=="user")
                                                    <a class="edit-icons toggle_note-btn" href="#"><i class="fas fa-pen"></i></a>

                                                    <div class="note-box">
                                                        <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                        <p>Add note</p>
                                                        <div class="d-flex">
                                                            @if (@$complete->notes->note !=null)
                                                            <form method="post" action="{{route('edit.note',@$complete->notes->id)}}">
                                                                @else
                                                                <form method="post" action="{{route('add.note',$complete->id)}}">
                                                                    @endif

                                                                    @csrf
                                                                    <textarea required name="note" class="form-control">{{@$complete->notes->note}}</textarea>

                                                                    <button type="submit" class="confirm_dropdown-btn">

                                                                        @if (@$complete->notes->note !=null)
                                                                        Update
                                                                        @else
                                                                        Save
                                                                        @endif
                                                                    </button>
                                                                    <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                                </form>
                                                        </div>
                                                    </div>
                                                    @endif

                                                </td>
                                                <td>
                                                    <form method="post" action="{{route('accept.case',$complete->id)}}">
                                                        @csrf
                                                        <button type="submit" class="accept_btn">Accept</button>
                                                    </form>

                                                    <form method="post" action="{{route('decline.case',$complete->id)}}">
                                                        @csrf
                                                        <button type="submit" class="decline-btn">Decline</button>
                                                    </form>



                                                </td>
                                            </tr>
                                            @empty

                                            <h2>No Complete Consultation.</h2>

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