<div>
    <div class="lawyer_conultation-wrapper">
        <div class="tabs_design-wrap three_tabs-layout">
            <div class="lawyer-tabs_lists">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Upcoming">Upcoming</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Complete">Complete</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Accepted">Accepted</a>
                    </li>
                </ul>
            </div>


            <div class="lawyer-tabs_contents">
                <form class="form-design">
                    <div class="tab-content">
                        <div id="Upcoming" class="container tab-pane active">

                            <div class="table-responsive table-design">
                                <table style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Practice Area</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($upcomingConsultations as $upcoming)
                                        <tr>
                                            <td>{{$upcoming->user->first_name}}</td>
                                            <td>{{$upcoming->user->last_name}}</td>
                                            <td>Car Accident</td>
                                            <td>{{date('d-m-y', strtotime($upcoming->booking_date)) }}</td>
                                            <td>{{$upcoming->booking_time}} - {{date('H:i:A', strtotime($upcoming->booking_time. ' +30 minutes'))}} </td>
                                            <td>
                                                <div class="dropdown reshedule_dropdowns">
                                                    <button class="toggle_cstm-btn" type="button">Reshedule</button>
                                                    <div class="reshedule_wrap-box">
                                                        <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
                                                        <p>Resheduling consultation will hurt your ratings</p>
                                                        <div class="d-flex">
                                                            <a class="confirm_dropdown-btn" wire:loading.remove wire:click="cancelBooking({{$upcoming->id}})">Confirm</a>
                                                            <a class="confirm_dropdown-btn" wire:loading wire:target="cancelBooking">
                                                                <i class="fa fa-spin fa-spinner"></i>
                                                            </a>
                                                            <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty

                                        <h2>No Upcoming Consultation.</h2>

                                        @endforelse


                                    </tbody>
                                </table>


                            </div>

                        </div>

                        <div id="Complete" class="container tab-pane fade">

                            <div class="table-responsive table-design">
                                <table style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Practice Area</th>
                                            <th>Date</th>
                                            <th>Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($completeConsultations as $complete)
                                        <tr>
                                            <td>{{$complete->first_name}}</td>
                                            <td>{{$complete->last_name}}</td>
                                            <td>Car Accident</td>
                                            <td>{{$complete->booking_date}}</td>
                                            <td>
                                                <a class="view-icon showNote" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons showModal" href="javascript::void(0)" wire:click="getNoteId('{{$complete->id}}')" ><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td>
                                                <button class="accept_btn">Accept</button>
                                                <button class="decline-btn">Decline</button>
                                            </td>
                                        </tr>

                                        @empty

                                        <h2>No Complete Consultation.</h2>

                                        @endforelse


                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="Accepted" class="container tab-pane fade">

                            <div class="table-responsive table-design">
                                <table style="width:100%">
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
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                        <tr>
                                            <td>Derek</td>
                                            <td>Sherman</td>
                                            <td><a href="mailto:akceb@ger.co.uk">akceb@ger.co.uk</a></td>
                                            <td>07-16-2022</td>
                                            <td>
                                                <a class="view-icon" href="#"><i class="fas fa-eye"></i></a>
                                                <a class="edit-icons" href="#"><i class="fas fa-pen"></i></a>
                                            </td>
                                            <td><a href="tel:555.555.5555">555.555.5555</a></td>
                                            <td>Car Accident</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- The Modal -->
            <div wire:ignore class="modal" id="notesModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Notes</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-grouph input-design">
                                <textarea class="form-control textarea-design" wire:model="note" placeholder="Make note"></textarea>
                                {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" wire:click="addNote()">Save</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Accept Modal Start Here-->
            <div wire:ignore.self class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModal" aria-hidden="true">
                <div class="modal-dialog modal_style">
                    <button type="button" class="btn btn-default close closeModal">
                        <i class="fas fa-close"></i>
                    </button>
                    <div class="modal-content">
                        <form>
                            <div class="modal-header modal_h">
                                <h3>Add/Edit Note</h3>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" wire:model="note" class="form-control">
                                        {!! $errors->first('note', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label></br>
                                        <input type="radio" name="status" wire:model="status" value="1"> Active
                                        <input type="radio" name="status" wire:model="status" value="0"> De-active
                                        {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
                                    </div>

                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <button type="button" class="btn_s b-0" wire:click="addNotes()" wire:loading.attr="disabled">
                                    <i wire:loading wire:target="addNotes()" class="fas fa-spin fa-spinner"></i> Save
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- Accept Modal Close Here-->
        </div>
    </div>

    <!-- Accept Modal Close Here-->
    @push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('noteFormClose', () => {
                $('#notesModal').modal('hide');
            });
            window.livewire.on('noteFormShow', () => {
                $('#notesModal').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {

            $('#notesModal').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#notesModal').modal('hide');
        });
    </script>
    @endpush
</div>