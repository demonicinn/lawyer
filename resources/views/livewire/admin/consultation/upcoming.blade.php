{{--
<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">

</div>
--}}
<div id="Upcoming" class="container tab-pane active">
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
                @if (count($upcomingConsul)>0)
                @foreach ($upcomingConsul as $upcoming)
                <tr>
                    <td>{{$upcoming->$role->name}}</td>
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
                    <td>{{date('m/d/Y', strtotime($upcoming->booking_date)) }}</td>
                    <td>{{date('g:i A', strtotime($upcoming->booking_time))}} - {{date('g:i A', strtotime($upcoming->booking_time. ' +30 minutes'))}} </td>

                </tr>
                @endforeach
                @else
            <tfoot>
                <tr>
                    <td colspan="6" class="text-center pt-3">
                        <h4>No consultations found</h4>
                    </td>
                </tr>
            </tfoot>
            @endif

            </tbody>
        </table>
    </div>

</div>