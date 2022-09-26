<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">
</div>
<div id="Cases" class="container tab-pane fade active show">
    <div class="table-responsive table-design">
        <table style="width:100%" id="laravel_datatable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date Accepted</th>
                    <th>Details</th>
                    <th>Phone</th>
                    <th>Practice Area</th>
                </tr>
            </thead>
            <tbody>

                @php
                $role = 'user';
                if(Auth::user()->role == 'user'){
                $role = 'lawyer';
                }
                @endphp
                @forelse ($acceptConsul as $accepted)
                <tr>
                    <td>{{$accepted->$role->first_name}}</td>
                    <td>{{$accepted->$role->last_name}}</td>
                    <td>{{$accepted->$role->email}}</td>
                    <td>{{date('d-m-y', strtotime($accepted->updated_at)) }}</td>
                    <td>
                        <a class="view-icon info_icns" href="#"><i class="fas fa-eye"></i></a>
                        <div class="info_icns_note_name">
                            @if (@$accepted->notes->note !=null)
                            {{@$accepted->notes->note}}

                            @endif
                        </div>

                        @if (Auth::user()->role=="lawyer")
                        <a class="edit-icons toggle_note-btn" href="#"><i class="fas fa-pen"></i></a>
                        <div class="note-box">
                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                            <p>Add note</p>
                            <div class="d-flex">
                                @if (@$accepted->notes->note !=null)
                                <form method="post" action="{{route('edit.note',@$accepted->notes->id)}}">
                                    @else
                                    <form method="post" action="{{route('add.note',$accepted->id)}}">
                                        @endif

                                        @csrf
                                        <textarea required name="note" class="form-control">{{@$accepted->notes->note}}</textarea>

                                        <button type="submit" class="confirm_dropdown-btn">

                                            @if (@$accepted->notes->note !=null)
                                            Update
                                            @else
                                            Save
                                            @endif
                                        </button>
                                    </form>
                                    <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                            </div>
                        </div>
                        @endif
                    </td>
                    <td>{{$accepted->$role->contact_number}}</td>
                    <td>Car Accident</td>
                </tr>
                @empty
                <h2>No Accepted Consultation.</h2>
                @endforelse
            </tbody>
        </table>
    </div>

</div>