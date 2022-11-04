@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('user') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Portal</a>
            <a href="{{ route('user.billing.create') }}" class="btn btn-success"> Add Card</a>
        </div>

        <div class="table-responsive table-design">
            <table style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Card number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cards as $card)
                    <tr>
                        <td>{{ @$card->card_name }}</td>
                        <td>{{ @$card->card_number }}</td>
                        <td>
                            <a href="{{ route('user.billing.destroy', $card->id) }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

      
    </div>
</section>
@endsection