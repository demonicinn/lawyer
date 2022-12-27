<div>

 <div class="add-search-box">
        <div class="form-group">
            <input wire:model="search" class="form-control search-box" type="text" placeholder="Search">
        </div>
    </div>
    <div  >
        <table class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>
						<a wire:click.prevent="sortBy('first_name')" href="javascript:void(0)">Name
							@include('includes._sort-icon', ['field' => 'first_name'])
						</a>
					</th>
					<th>
						<a wire:click.prevent="sortBy('email')" href="javascript:void(0)">Email
							@include('includes._sort-icon', ['field' => 'email'])
						</a>
					</th>
					<th>
						<a wire:click.prevent="sortBy('contact_number')" href="javascript:void(0)">Contact Number
							@include('includes._sort-icon', ['field' => 'contact_number'])
						</a>
					</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lawyers as $lawyer)
                @php
                    $totalCount = $lawyer->lawyerReviews()->count();
                    $totalRating = $lawyer->lawyerReviews()->sum('rating');
                    
                    if($totalCount > 0){
                        $overAllRating = $totalRating / $totalCount;
                        
                        
                        $countCancleBookings = $lawyer->booking()->where('is_canceled', '1')->where('booking_date', '>=', $date3Months)->count();
                        
                        $checkRating = 0;
                        if($countCancleBookings > '0' && $countCancleBookings <= '2'){
                            $checkRating = 0.5;
                        }
                        if($countCancleBookings >= '3' && $countCancleBookings <= '9'){
                            $checkRating = 1;
                        }
                        if($countCancleBookings >= '10'){
                            $checkRating = 2;
                        }
                    
                        $newRating = $overAllRating - $checkRating;
                    
                        $rating = number_format($newRating, 1);
                    }
                    else {
                        $rating = 0;
                    }
                @endphp
                <tr>
                    <td>{{ $lawyer->name }}</td>
                    <td>{{ $lawyer->email }}</td>
                    <td>{{ $lawyer->contact_number }}</td>
                    <td>{{ @$rating > 0 ? $rating : '' }}</td>
                    <td>
                        @if ( $lawyer->status == '0' )
                            <button type="button"  wire:click="activate('{{ $lawyer->id }}')" class="accept_btn">Activate</button>
                        @elseif ( $lawyer->status == '1' )
                            <button type="button" wire:click="deactivate('{{ $lawyer->id }}') " class="decline-btn">Deactivate</button>
                        @endif
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
    {{ $lawyers->links() }}
    
    <style>
        th a {
    text-decoration: none;
    color: #212529;
}
    </style>
</div>
