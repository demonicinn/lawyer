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
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->name }}</td>
                    <td>{{ ucfirst($subscription->type) }}</td>
                    <td>{{ $subscription->price ? '$'.$subscription->price : '' }}</td>
                    <td>
                        @if($subscription->status=='1')
                        <button type="button" class="accept_btn">Active</button>
                        @else
                        <button type="button" class="decline-btn">De-active</button>
                        @endif
                    </td>
                    <td>
                        <a class="edit-icons" href="javascript::void(0)" wire:click="edit('{{$subscription->id}}')"><i class="fas fa-pen"></i></a>
                        <a class="view-icon" href="javascript::void(0)" wire:click="delete('{{$subscription->id}}')"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="pagination-container" class="pagination-container-saved">{{$subscriptions->links()}}</div>

<!-- Trial period -->
<hr>
<form class="form-inline"  wire:submit.prevent="updateTrialDays">
  <div class="row justify-content-center trial_row">
    <div class="form-group mb-2 col-md-4">
        
      <input wire:model="trial_days" type="number" class="form-control" id="trial_days" placeholder="Trial days" value="{{ isset( $trial_days ) ? $trial_days : '' }}">
	@error ('trial_days') <span class="help-block">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-2">
	<button type="submit" class="btn-design-first mb-2">Update Trial Days</button>
    </div>
 </div>
</form>
<!-- Trial period End -->


    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade common_modal modal-design" id="subscriptionForm" tabindex="-1" aria-labelledby="subscriptionForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>
                <form>
                    <div class="modal-header modal_h">
                        <h3>Add/Edit Subscription</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <div class="form-grouph input-design">
                                <label>Name</label>
                                <input type="text" wire:model="name">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph select-design">
                                <label>Type</label>
                                <select wire:model="type">
                                    <option value="">Select Type</option>
                                    {{--<option value="free">Free</option>--}}
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                                {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-grouph input-design">
                                <label>Price</label>
                                <input type="text" wire:model="price" maxlength="8">
                                {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph">
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
            window.livewire.on('subscriptionFormClose', () => {
                $('#subscriptionForm').modal('hide');
            });
            window.livewire.on('subscriptionFormShow', () => {
                $('#subscriptionForm').modal('show');
            });
        });
        $(document).on('click', '.showModal', function(e) {
            $('#subscriptionForm').modal('show');
        });
        $(document).on('click', '.closeModal', function(e) {
            $('#subscriptionForm').modal('hide');
        });
    </script>
    @endpush
</div>
