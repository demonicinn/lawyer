<div>

 <div class="add-search-box">
        <div class="row pb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <input wire:model="search" class="form-control search-box" type="text" placeholder="Search">
                </div>
            </div>
            <div class="col-md-6 date_filter">
                <div class="form-group">
                    <input wire:model="from_date" class="form-control" type="date" max="{{$to_date}}">
                    <input wire:model="to_date" class="form-control" type="date" min="{{$from_date}}">
                </div>
            </div>
        </div>
    </div>
    <div  >
        <table class="table table-responsive table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>
                        {{--
						<a wire:click.prevent="sortBy('first_name')" href="javascript:void(0)">Name
							@include('includes._sort-icon', ['field' => 'first_name'])
						</a>
						--}}
						Name
					</th>
					<th>
						<a wire:click.prevent="sortBy('amount')" href="javascript:void(0)">Amount
							@include('includes._sort-icon', ['field' => 'amount'])
						</a>
					</th>
					<th>
						<a wire:click.prevent="sortBy('payment_type')" href="javascript:void(0)">Type
							@include('includes._sort-icon', ['field' => 'payment_type'])
						</a>
					</th>
					<th>
						<a wire:click.prevent="sortBy('created_at')" href="javascript:void(0)">Date
							@include('includes._sort-icon', ['field' => 'created_at'])
						</a>
					</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ @$transaction->user->name }}</td>
                    <td>${{ @$transaction->amount }}</td>
                    <td>{{ @$transaction->payment_type ? ucfirst($transaction->payment_type) : '' }}</td>
                    <td>{{ @$transaction->created_at->format('m-d-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="pagination-container" class="pagination-container-saved">{{$transactions->onEachSide(1)->links()}}</div>
    
    <style>
        th a {
    text-decoration: none;
    color: #212529;
}
    </style>
</div>
