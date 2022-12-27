{{--
<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">
</div>
--}}
<div id="Complete" class="container tab-pane fade active show">
    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>{{$user->role=='user' ? 'Lawyer Name' : 'Client Name' }}</th>
                    <th>Practice Area</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
				@php
					$role = 'user';
				if($user->role == 'user'){
					$role = 'lawyer';
				}
				@endphp
                @forelse ($completeConsul as $complete)
                <tr>
                    <td>{{$complete->$role->name}}</td>
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
                    <td>{{date('m/d/Y', strtotime($complete->booking_date)) }}</td>
                    <td>{{date('g:i A', strtotime($complete->booking_time))}} - {{date('g:i A', strtotime($complete->booking_time. ' +30 minutes'))}} </td>


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