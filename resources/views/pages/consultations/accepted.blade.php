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
                            <div id="Cases" class="container tab-pane fade active show">
                                <div class="table-responsive table-design">
                                    <table style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Practice Area</th>
                                                <th>Date Accepted</th>
                                                <th>Details</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @php
                                            $role = 'user';
                                            if(Auth::user()->role == 'user'){
                                            $role = 'lawyer';
                                            }
                                            @endphp
                                            @forelse ($accptedConsultations as $accepted)
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
                                                    @if (@$accepted->notes->note != null)
                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $accepted->id }}" data-type="view"><i class="fas fa-eye"></i></a>
                                                    @endif

                                                    @if (Auth::user()->role=="lawyer")
                                                    <a class="view-icon info_icns mdl" href="javascript:void(0)" data-id="myNoteModal_{{ $accepted->id }}" data-type="edit"><i class="fas fa-edit"></i></a>
                                                    @endif

                                                    <div id="myNoteModal_{{ $accepted->id }}" class="modal fade common_modal  noteModal" role="dialog">
                                                    
                                                      <div class="modal-dialog">
                                                      <button type="button" class="btn btn-default close cloaseModal">  <i class="fas fa-close"></i></button>
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                          <div class="modal-header modal_h">
                                                            <h3 class="modal-title">Notes</h3>
                                                          </div>




                                                          @if (Auth::user()->role=="lawyer")
                                                            @if (@$accepted->notes->note != null)
                                                            <form method="post" action="{{route('edit.note',@$accepted->notes->id)}}">
                                                            @else
                                                            <form method="post" action="{{route('add.note',$accepted->id)}}">
                                                            @endif

                                                            @csrf

                                                              <div class="modal-body">
                                                                
                                                                @if (@$accepted->notes->note !=null)
                                                                <div class="view">{{@$accepted->notes->note}}</div>
                                                                @endif

                                                                <div class="edit">
                                                                <textarea required name="note" class="form-control">{{@$accepted->notes->note}}</textarea>
                                                            </div>

                                                              </div>
                                                              <div class="modal-footer justify-content-center">
                                                                <button type="submit" class="   btn-design-first edit">
                                                                    @if (@$accepted->notes->note !=null)
                                                                    Update
                                                                    @else
                                                                    Save
                                                                    @endif
                                                                </button>

                                                                    <!-- <button type="button" class="btn btn-default cloaseModal">Close</button> -->
                                                                </div>
                                                          @else

                                                          <div class="modal-body">
                                                                
                                                                @if (@$accepted->notes->note !=null)
                                                                <p>{{@$accepted->notes->note}}</p>
                                                                @endif

                                                              </div>

                                                            <div class="modal-footer">
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default cloaseModal">Close</button>
                                                                </div>
                                                            </div>
                                                          @endif

                                                      </form>
                                                        </div>

                                                      </div>
                                                    </div>


                                                </td>
                                                <td>{{$accepted->$role->contact_number}}</td>
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