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
                    <th>Page</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $seo)
                <tr>
                    <td>{{ $seo->page }}</td>
                    <td>{{ $seo->title }}</td>
                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="edit('{{$seo->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="delete('{{$seo->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="pagination-container" class="pagination-container-saved">{{$data->links()}}</div>

    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade common_modal modal-design" id="seoForm" tabindex="-1" aria-labelledby="stateForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>

                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit Seo</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-group">
                                <label>Select Page</label>
                                <select class="form-control" wire:model="page_name">
									<option value="">Select Page</option>
									<option value="home">Home</option>
									<option value="faq">FAQ</option>
									<option value="support">Support</option>
									<option value="about">About us</option>
									<option value="join-the-team">Join the Team</option>
									<option value="privacy-policy">Privacy Policy</option>
									<option value="terms-of-service">Term And Conditions</option>
									<option value="how-to-add-lawyer-link">How to add lawyer link</option>
									<option value="narrow-down-candidates">Find my lawyer</option>
									<option value="narrow-down-litigations">Litigation</option>
									<option value="narrow-down-contracts">Contracts</option>
									<option value="lawyers">Search Page</option>
									<option value="style-guide">Style Guide</option>
								</select>
                                {!! $errors->first('page_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Meta Title</label></br>
                                <input type="text" wire:model="title" class="form-control">
                                {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label></br>
                                <input type="text" wire:model="description" class="form-control">
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group">
                                <label>Meta Keywords</label></br>
                                <input type="text" wire:model="keywords" class="form-control">
                                {!! $errors->first('keywords', '<span class="help-block">:message</span>') !!}
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
            window.livewire.on('formClose', () => {
                $('#seoForm').modal('hide');
            });
            window.livewire.on('formShow', () => {
                $('#seoForm').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {
            $('#seoForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#seoForm').modal('hide');
        });
    </script>
    @endpush
</div>