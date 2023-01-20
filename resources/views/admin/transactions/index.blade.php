@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh admin_transactions_table">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Dashboard</a>
        </div>

        

        @livewire('admin.transactions')
        
        {{--
        <div class="table-responsive table-design">
            <table style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
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
        --}}
      
    </div>
</section>
@endsection