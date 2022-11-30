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
                            <div id="Cases" class="container tab-pane fade active show">
                                <div class="table-responsive table-design">
                                    <table style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>{{$authUser->role=='user' ? 'Lawyer Name' : 'Client Name' }}</th>
                                                <th>Email</th>
                                                <th>Practice Area</th>
                                                <th>Date Accepted</th>
                                                <th>Details</th>
                                                <th>Phone</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                                $role = 'user';
                                            if($authUser->role == 'user'){
                                                $role = 'lawyer';
                                            }
                                            @endphp
                                            @forelse ($accptedConsultations as $accepted)
                                            @php
                                                $notes = $accepted->notes()->where('user_id', $authUser->id)->first();
                                            @endphp
                                            <tr>
                                                <td>{{$accepted->$role->first_name}} {{$accepted->$role->last_name}}</td>
                                                <td>{{$accepted->$role->email}}</td>
                                                <td>
                                                    @if($accepted->search_data)
                                                    @php
                                                        $search = json_decode($accepted->search_data);
                                                    @endphp
                                                        @foreach($search as $id)
                                                            @if($accepted->search_type == 'litigations')
                                                            {{ litigationsData($id) }}
                                                            @else
                                                            {{ contractsData($id) }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>{{date('m-d-Y', strtotime($accepted->updated_at)) }}</td>
                                                <td>
                                                    @if (@$notes->note != null)
                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $accepted->id }}" data-type="view"><i class="fas fa-eye"></i></a>
                                                    @endif

                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $accepted->id }}" data-type="edit"><i class="fas fa-edit"></i></a>
                                                

                                                    <div id="myNoteModal_{{ $accepted->id }}" class="modal fade common_modal  noteModal" role="dialog">
                                                    
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
                                                            <form method="post" action="{{route('add.note',$accepted->id)}}">
                                                            @endif

                                                            @csrf

                                                              <div class="modal-body">
                                                                
                                                                @if (@$notes->note !=null)
                                                                <div class="view">{{@$notes->note}}</div>
                                                                @endif

                                                                <div class="edit">
                                                                <textarea required name="note" class="form-control">{{@$notes->note}}</textarea>
                                                            </div>

                                                              </div>
                                                              <div class="modal-footer justify-content-center">
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
                                                <td class="phone">{{$accepted->$role->contact_number}}</td>
                                                <td>${{$accepted->total_amount}}</td>
                                            </tr>

                                            @empty

                                        <tfoot>
                                            <tr>
                                                <td colspan="7" class="text-center pt-3" >
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

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


$('.phone').inputmask('(99)-9999-9999');

</script>
@endsection