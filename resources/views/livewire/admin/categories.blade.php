<div>
    <button type="button" class="accept_btn showModal">Add</button>

    <div class="table-responsive table-design">
        <table style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if($category->status=='1')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">De-active</button>
                        @endif
                    </td>
                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="edit('{{$category->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="delete('{{$category->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade" id="categoryForm" tabindex="-1" aria-labelledby="categoryForm" aria-hidden="true">
        <div class="modal-dialog modal_style">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>
            <div class="modal-content">
                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit Category</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" wire:model="name" class="form-control">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
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
                        <button type="button" class="btn_s b-0" wire:click="store" wire:loading.attr="disabled">
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
        $(document).ready(function () {
			window.livewire.on('categoryFormClose', () => {
                $('#categoryForm').modal('hide');
            });
            window.livewire.on('categoryFormShow', () => {
                $('#categoryForm').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {
            $('#categoryForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#categoryForm').modal('hide');
        });
    </script>
    @endpush
</div>