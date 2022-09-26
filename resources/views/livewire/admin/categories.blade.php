<div>
    <button type="button" class="accept_btn showModal">Add Category</button>

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
                <tr style="background: grey;">
                    <td>{{ $category->name }}<a class="btn_add mr-2" wire:click="addItemTypes('{{$category->id}}')">
                            <i class="fas fa-plus-circle showItemModal"></i> Add Item
                        </a>
                    <td>
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

                    @if($category->items && count($category->items)>0)
                <tr>
                    <thead>
                        <th>Item</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                </tr>
                @foreach($category->items as $i => $list)
                <tr>
                    <td>{{ $list->name }}</td>
                    <td>
                        @if($list->status=='1')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">De-active</button>
                        @endif
                    </td>
                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="editItem('{{$list->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="deleteItem('{{$list->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="pagination-container" class="pagination-container-saved">{{$categories->links()}}</div>


    <!-- Accept Category Modal Start Here-->
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
                                <input type="text" wire:model="category_name" class="form-control">
                                {!! $errors->first('category_name', '<span class="help-block">:message</span>') !!}
                                
                            </div>
                            <div class="status_search">
                                <div class="form-group">
                                    <label>Is Multiselect</label></br>
                                    <input type="radio" name="is_multiselect" wire:model="is_multiselect" value="1"> Yes
                                    <input type="radio" name="is_multiselect" wire:model="is_multiselect" value="0"> No
                                    {!! $errors->first('is_multiselect', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-group">
                                    <label>Is Search</label></br>
                                    <input type="radio" name="cat_search" wire:model="cat_search" value="1"> Yes
                                    <input type="radio" name="cat_search" wire:model="cat_search" value="0"> No
                                    {!! $errors->first('cat_search', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-group">
                                    <label>Status</label></br>
                                    <input type="radio" name="cat_status" wire:model="cat_status" value="1"> Active
                                    <input type="radio" name="cat_status" wire:model="cat_status" value="0"> De-active
                                    {!! $errors->first('cat_status', '<span class="help-block">:message</span>') !!}
                                </div>
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


    <!-- Accept items Modal Start Here-->

    <div wire:ignore.self class="modal fade" id="itemForm" tabindex="-1" aria-labelledby="itemForm" aria-hidden="true">
        <div class="modal-dialog modal_style">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>
            <div class="modal-content">
                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit Item</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" wire:model="item_name" class="form-control">
                                {!! $errors->first('item_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Status</label></br>
                                <input type="radio" name="item_status" wire:model="item_status" value="1"> Active
                                <input type="radio" name="item_status" wire:model="item_status" value="0"> De-active
                                {!! $errors->first('item_status', '<span class="help-block">:message</span>') !!}
                            </div>

                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <button type="button" class="btn_s b-0" wire:click="storeItem" wire:loading.attr="disabled">
                            <i wire:loading wire:target="storeItem" class="fas fa-spin fa-spinner"></i> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Accept Modal Close Here-->
    @push('scripts')
    <script>
        // for Category modal
        $(document).ready(function() {
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

        // for Item modal

        $(document).ready(function() {
            window.livewire.on('itemFormClose', () => {
                $('#itemForm').modal('hide');
            });
            window.livewire.on('itemFormShow', () => {
                $('#itemForm').modal('show');
            });
        });
        $(document).on('click', '.showItemModal', function(e) {

            $('#itemForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#itemForm').modal('hide');
        });
    </script>
    @endpush
</div>