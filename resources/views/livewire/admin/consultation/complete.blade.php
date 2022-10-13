<div class="form-group">
    <input type="search" wire:model="search" placeholder="Search">
</div>
<div id="Complete" class="container tab-pane fade active show">
    <div class="table-responsive table-design">
        <table style="width:100%" id="laravel_datatable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Practice Area</th>
                    <th>Date</th>
                    <th>Details</th>
                    @if (Auth::user()->role == "lawyer")
                    <th>Action</th>
                    @endif

                </tr>
            </thead>
            <tbody>

                @php
                $role = 'user';
                if(Auth::user()->role == 'user'){
                $role = 'lawyer';
                }
                @endphp
                @forelse ($completeConsul as $complete)
                <tr>
                    <td>{{$complete->$role->first_name}}</td>
                    <td>{{$complete->$role->last_name}}</td>
                    <td>Car Accident</td>
                    <td>{{date('d-m-y', strtotime($complete->booking_date)) }}</td>
                    <td>
                        <a class="view-icon info_icns" href="#"><i class="fas fa-eye"></i></a>

                        <div class="info_icns_note_name">
                            @if (@$complete->notes->note !=null)
                            {{@$complete->notes->note}}

                            @endif
                        </div>

                        @if (Auth::user()->role == "lawyer")
                        <a class="edit-icons toggle_note-btn" href="#"><i class="fas fa-pen"></i></a>

                        <div class="note-box">
                            <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                            <p>Add note</p>
                            <div class="d-flex">
                                @if (@$complete->notes->note !=null)
                                <form method="post" action="{{route('edit.note',@$complete->notes->id)}}">
                                    @else
                                    <form method="post" action="{{route('add.note',$complete->id)}}">
                                        @endif

                                        @csrf
                                        <textarea required name="note" class="form-control">{{@$complete->notes->note}}</textarea>

                                        <button type="submit" class="confirm_dropdown-btn">

                                            @if (@$complete->notes->note !=null)
                                            Update
                                            @else
                                            Save
                                            @endif
                                        </button>
                                        <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                    </form>
                            </div>
                        </div>
                        @endif
                    </td>

                    @if (Auth::user()->role == "lawyer")
                    <td class="form_td">
                        <form method="post" action="{{route('accept.case',$complete->id)}}">
                            @csrf
                            <button type="submit" class="accept_btn">Accept</button>
                        </form>

                        <form method="post" action="{{route('decline.case',$complete->id)}}">
                            @csrf
                            <button type="submit" class="decline-btn">Decline</button>
                        </form>
                    </td>
                    @endif

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