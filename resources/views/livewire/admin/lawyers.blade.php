<div>

 <!--    <div class="add-search-box">
        <div class="form-group">
            <input wire:model="search" class="form-control search-box" type="text" placeholder="Search">
        </div>
    </div> -->
    <div  >
        <table id="lawyers-table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lawyers as $lawyer)
                <tr>
                    <td>{{ $lawyer->name }}</td>
                    <td>{{ $lawyer->email }}</td>
                    <td>{{ $lawyer->contact_number }}</td>
                    <td>

                        @if ( @$lawyer->details->review_request == '0' )
                            <p> Submission Pending </p>
                        @elseif ( @$lawyer->details->is_verified == 'yes')
                        
                            {{-- Submission Approved --}}

                            @if ( $lawyer->status == '1' )
                                <button type="button" wire:click="deactivate('{{ $lawyer->id }}') " class="decline-btn">Deactivate</button>
                            @elseif ( $lawyer->status == '0' )
                                <button type="button" wire:click="activate('{{ $lawyer->id }}')" class="accept_btn">Activate</button>
                            @else 
                                <p>Blocked</p>
                            @endif                            
                        @else 
                            <p> Approval Pending </p>
                        @endif
                        {{--
                        @if(@$lawyer->details->is_verified=='yes')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">In-active</button>
                        @endif
                        --}}
                    </td>
                    <td>
                        @if(@$lawyer->details->review_request=='1' && $lawyer->details->is_verified=='no')

                        <button type="button" class="btn btn-sm btn-success" wire:click="review('{{$lawyer->id}}', 'accept')">Accept</button>
                        <button type="button" class="btn btn-sm btn-danger" wire:click="review('{{$lawyer->id}}', 'declined')">Declined</button>
                       
                        {{--
                        <a href="{{route('admin.laywer.view',$lawyer->id)}}">
                            <button type="button" class="btn btn-sm btn-info "><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>
                        --}}
                        @endif
                        
                        {{--
                        @if(@$lawyer->details->review_request!='1' && $lawyer->details->is_verified!='no')
                        <a href="{{route('admin.laywer.view',$lawyer->id)}}">
                            <button type="button" class="btn btn-sm btn-info "><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>

                        @endif
                        --}}

                        <a href="{{route('admin.laywer.view',$lawyer->id)}}">
                            <button type="button" class="btn btn-sm btn-info "><i class="fa fa-eye" aria-hidden="true"></i></button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div id="pagination-container" class="pagination-container-saved">{{$lawyers->links()}}</div> --}}
</div>