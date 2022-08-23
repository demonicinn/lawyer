<div>
<div class="table-responsive table-design">
        <table style="width:100%">
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
                        @if($lawyer->status=='1')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">De-active</button>
                        @endif
                    </td>
                    <td>
                        @if(@$lawyer->details->review_request=='1' && $lawyer->details->is_verified=='no')
                        <button type="button" class="btn btn-sm btn-success" wire:click="review('{{$lawyer->id}}', 'accept')">Accept</button>
                        <button type="button" class="btn btn-sm btn-danger" wire:click="review('{{$lawyer->id}}', 'declined')">Declined</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>
