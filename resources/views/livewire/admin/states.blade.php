<div>
    <div class="add-search-box">
        <div class="add-litigations py-3">
            <button type="button" class="accept_btn showModal">Add</button>
        </div>
        <div class="form-group">
            <input wire:model="search" class="form-control search-box" type="text" placeholder="Search">
        </div>
    </div>

    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($states as $state)
                <tr>
                    <td>{{ $state->name }}</td>
                    <td>{{ $state->code }}</td>
                    <td>
                        @if($state->status=='1')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">De-active</button>
                        @endif
                    </td>
                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="edit('{{$state->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="delete('{{$state->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="pagination-container" class="pagination-container-saved">{{$states->links()}}</div>

    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade common_modal modal-design" id="stateForm" tabindex="-1" aria-labelledby="stateForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>
                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit Contract</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" wire:model="name" class="form-control">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" wire:model="code" class="form-control">
                                {!! $errors->first('code', '<span class="help-block">:message</span>') !!}
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
            window.livewire.on('stateFormClose', () => {
                $('#stateForm').modal('hide');
            });
            window.livewire.on('stateFormShow', () => {
                $('#stateForm').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {
            $('#stateForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#stateForm').modal('hide');
        });
    </script>
    @endpush
</div>