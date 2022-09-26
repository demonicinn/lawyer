<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">

</div>
<div id="Upcoming" class="container tab-pane active">
    <div class="table-responsive table-design">
        <table style="width:100%" id="laravel_datatable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Practice Area</th>
                    <th>Date</th>
                    <th>Time</th>

                </tr>
            </thead>
            <tbody>
                @php
                $role = 'user';
                if(Auth::user()->role == 'user'){
                $role = 'lawyer';
                }
                @endphp
                @forelse ($upcomingConsul as $upcoming)
                <tr>
                    <td>{{$upcoming->$role->first_name}}</td>
                    <td>{{$upcoming->$role->last_name}}</td>
                    <td>Car Accident</td>
                    <td>{{date('d-m-y', strtotime($upcoming->booking_date)) }}</td>
                    <td>{{date('g:i A', strtotime($upcoming->booking_time))}} - {{date('g:i A', strtotime($upcoming->booking_time. ' +30 minutes'))}} </td>

                </tr>
                @empty

                <h2>No Upcoming Consultation.</h2>

                @endforelse
            </tbody>
        </table>
    </div>

</div>