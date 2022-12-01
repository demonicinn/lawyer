@extends('layouts.app')
@section('content')
@php
    $authUser = auth()->user();
@endphp
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
                                                <th>{{$authUser->role=='user' ? 'Lawyer Name' : 'Client Name' }}</th>
                                                <th>Practice Area</th>
                                                <th>Date</th>
                                                <th>Details</th>
                                                <th>Cost</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $role = 'user';
                                            if($authUser->role == 'user'){
                                            $role = 'lawyer';
                                            }
                                            @endphp
                                            @forelse ($completeConsultations as $complete)
                                            @php
                                                $notes = $complete->notes()->where('user_id', $authUser->id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$complete->$role->first_name}} {{$complete->$role->last_name}}</td>
                                                <td>
                                                    @if($complete->search_data)
                                                    @php
                                                        $search = json_decode($complete->search_data);
                                                    @endphp
                                                        @foreach($search as $id)
                                                            @if($complete->search_type == 'litigations')
                                                            {{ litigationsData($id) }}
                                                            @else
                                                            {{ contractsData($id) }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{date('m-d-Y', strtotime($complete->booking_date)) }}</td>
                                                <td>
                                                    @if (@$notes->note != null)
                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $complete->id }}" data-type="view"><i class="fas fa-eye"></i></a>
                                                    @endif

                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $complete->id }}" data-type="edit"><i class="fas fa-edit"></i></a>
                                                   

                                                    <div id="myNoteModal_{{ $complete->id }}" class="modal fade common_modal  noteModal" role="dialog">
                                                    
                                                      <div class="modal-dialog modal-dialog-centered">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                        <button type="button" class="btn btn-default close cloaseModal">  <i class="fas fa-close"></i></button>
                                                          <div class="modal-header modal_h">
                                                            <h3 class="modal-title">Notes</h3>
                                                          </div>


                                                            @if (@$notes->note != null)
                                                            <form method="post" action="{{route('edit.note',@$notes->id)}}">
                                                            @else
                                                            <form method="post" action="{{route('add.note',$complete->id)}}">
                                                            @endif

                                                            @csrf

                                                              <div class="modal-body">
                                                                
                                                                @if (@$notes->note != null)
                                                                <div class="view">{{@$notes->note}}</div>
                                                                @endif

                                                                <div class="edit">
                                                                <textarea required name="note" class="form-control">{{@$notes->note}}</textarea>
                                                            </div>

                                                              </div>
                                                              <div class="modal-footer">
                                                                <button type="submit" class="   btn-design-first edit">
                                                                    @if (@$notes->note !=null)
                                                                    Update
                                                                    @else
                                                                    Save
                                                                    @endif
                                                                </button>

                                                                    <!-- <button type="button" class="btn btn-default cloaseModal">Close</button> -->
                                                                </div>
                                                            </form>

                                                        </div>

                                                      </div>
                                                    </div>
                                                </td>

                                                <td>${{$complete->total_amount}}</td>
                                                <td class="form_td">
                                                    @if($complete->is_canceled=='1')
                                                        <button type="submit" class="decline-btn disabled">Rejected</button>
                                                    @else
                                                        @if ($authUser->role == "lawyer")
                                                        <form method="post" action="{{route('accept.case', $complete->id)}}" class="">
                                                            @csrf
                                                            <button type="submit" class="accept_btn">Accept</button>
                                                        </form>

                                                        <form method="post" action="{{route('decline.case', $complete->id)}}">
                                                            @csrf
                                                            <button type="submit" class="decline-btn">Decline</button>
                                                        </form>
                                                        @else
                                                        <form method="post" action="{{route('cancel.case', $complete->id)}}">
                                                            @csrf
                                                            <button type="submit" class="decline-btn">Reject lawyer</button>
                                                        </form>
                                                        @endif
                                                    @endif
                                                </td>

                                            </tr>
                                            @empty

                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-center pt-3">
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
<script>
$('.info_icns.mdl').on('click', function (){
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');

    $('#'+id).modal('show');


    $('#'+id+' .view').hide();
    $('#'+id+' .edit').hide();

    $('#'+id+' .'+type).show();

});


$('.cloaseModal').on('click', function (){
    $('.noteModal').modal('hide');
});

</script>
@endsection
