<div>
    <button type="button" class="accept_btn showModal">Add</button>

    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaves as $leave)
                <tr>
                 
                    <td>{{ date('l,j, F, Y', strtotime($leave->date)) }}</td>

                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="edit('{{$leave->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="delete('{{$leave->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade common_modal modal-design" id="leaveForm" tabindex="-1" aria-labelledby="leaveForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>
            <div class="modal-content">
                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit leave</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" wire:model="date" class="form-control" min="<?php echo date("Y-m-d"); ?>">
                                {!! $errors->first('date', '<span class="help-block">:message</span>') !!}
                            </div>


                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <button type="button" class="btn-design-first" wire:click="store" wire:loading.attr="disabled">
                            <i wire:loading wire:target="store" class="fas fa-spin fa-spinner"></i> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Accept Modal Close Here-->
    @push('scripts')
    <script>
        $(document).ready(function() {
            window.livewire.on('LeaveFormClose', () => {
                $('#leaveForm').modal('hide');
            });
            window.livewire.on('LeaveFormShow', () => {
                $('#leaveForm').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {
            $('#leaveForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#leaveForm').modal('hide');
        });
    </script>
    @endpush
</div>