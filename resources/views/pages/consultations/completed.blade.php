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
                                                @if (Auth::user()->role == "lawyer")
                                                <th>Action</th>
                                                @endif

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

                                                    @if (Auth::user()->role == "lawyer")
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

                                                @if (Auth::user()->role == "lawyer")
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
                                                @endif

                                            </tr>
                                            @empty

                                        <tfoot>
                                            <tr>
                                                <td class="text-center">
                                                    <h4>No consultations found</h4>
                                                </td>
                                            </tr>
                                        </tfoot>

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



@section('script')
<script>
{{--
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )
      }
    })
    --}}
</script>
@endsection