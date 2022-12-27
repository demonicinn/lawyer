{{--
<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">
</div>
--}}
<div id="Cases" class="container tab-pane fade active show">
    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>{{$user->role=='user' ? 'Lawyer Name' : 'Client Name' }}</th>
                    <th>Email</th>
                    <th>Date Accepted</th>
                    <th>Phone</th>
                    <th>Practice Area</th>
                </tr>
            </thead>
            <tbody>
				@php
					$role = 'user';
				if($user->role == 'user'){
					$role = 'lawyer';
				}
				@endphp
                @forelse ($acceptConsul as $accepted)
                <tr>
                    <td>{{$accepted->$role->name}}</td>
                    <td>{{$accepted->$role->email}}</td>
                    <td>{{date('m/d/Y', strtotime($accepted->updated_at)) }}</td>
                    
                    <td>{{$accepted->$role->contact_number}}</td>
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
                </tr>
                @empty
            <tfoot>
                <tr>
                    <td colspan="7" class="text-center pt-3">
                        <h4>No consultations found</h4>
                    </td>
                </tr>
            </tfoot>
            @endforelse
            </tbody>
        </table>
    </div>

</div>