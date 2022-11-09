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
                                                <th>Name</th>
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
                                                <td>{{$upcoming->$role->first_name}} {{$upcoming->$role->last_name}}</td>
                                                <td>
                                                    @if($upcoming->search_data)
                                                    @php
                                                        $search = json_decode($upcoming->search_data);
                                                    @endphp
                                                        @foreach($search as $id)
                                                            @if($upcoming->search_type == 'litigations')
                                                            {{ litigationsData($id) }}
                                                            @else
                                                            {{ contractsData($id) }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{date('m-d-Y', strtotime($upcoming->booking_date)) }}</td>
                                                <td>{{$start_time}} - {{$end_time}}</td>
                                                <td>
                                                    <div class="dropdown reshedule_dropdowns">
                                                        <button class="toggle_cstm-btn" type="button">Reschedule</button>

                                                        @if (Auth::user()->role == 'lawyer')

                                                        <div class="reshedule_wrap-box">
                                                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                            <p>Rescheduling consultation will hurt your ratings</p>
                                                            <div class="d-flex">
                                                                <a href="{{route('reschedule.booking',$upcoming->id)}}" class="accept_btn showModal">Confirm</a>

                                                                <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                            </div>
                                                        </div>

                                                        @else

                                                        <div class="reshedule_wrap-box">
                                                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                            <p>Rescheduling consultation will hurt your ratings</p>
                                                            <div class="d-flex">
                                                                <a href="{{route('reschedule.booking',$upcoming->id)}}" class="accept_btn showModal">Confirm</a>

                                                                <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                            </div>
                                                        </div>

                                                        @endif
                                                    </div>

                                                    @php
                                                        $date1Days = \Carbon\Carbon::parse($upcoming->booking_date.' '.$upcoming->booking_time)->subtract(1, 'days')->format('Y-m-d h:i:s');

                                                        $cDate = date('Y-m-d h:i:s');
                                                    @endphp
                                                    @if (Auth::user()->role == 'user' && $cDate <= $date1Days)
                                                    <button class="toggle_cstm-btn" style="background-color:#f93f64;" type="button" onclick="cancelBooking(`{{$upcoming->id}}`)">Cancel Booking</button>

                                                    <form id="cancel-form-{{$upcoming->id}}" action="{{ route('consultations.upcoming.cancel', $upcoming->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    </form>
                                                     @endif
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

@section('script')
<script>
    function cancelBooking(id) {

        Swal.fire({
            title: "Are you sure?",
            text: "Cancel Booking",
            type: "danger",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, Cancel!",
            closeOnConfirm: false

        }).then((result) => {

            if (result.isConfirmed) {
                $("#cancel-form-"+id).submit();
            }
        });
    }
</script>
@endsection