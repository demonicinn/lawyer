@extends('layouts.app')
@section('content')


<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Account Information</h2>
        </div>
        <div class="user_acc_info-wrapper">
            <form class="form-design row justify-content-center" method="post" action="{{route('lawyer.banking.store')}}">
                @csrf

                <div class="col-md-7">
                <div class="white-shadow-scnd-box ">
                    <div class="form">
                        <div class="form-grouph input-design">
                            <label>Account Holder Name*</label>
                            <input class="@error('account_holder_name') is-invalid @enderror" type="text" name="account_holder_name" value="{{ @$record->account_holder_name }}">
                            @error('account_holder_name')<div class="help-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-grouph input-design">
                            <label>Account Number*</label>
                            <input class="@error('account_number') is-invalid @enderror" type="text" name="account_number" value="{{ @$record->account_number }}">
                            @error('account_number')<div class="help-block">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-grouph input-design">
                            <label>Routing Number*</label>
                            <input class="@error('routing_number') is-invalid @enderror" type="text" name="routing_number" value="{{ @$record->routing_number }}">
                            @error('routing_number')<div class="help-block">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                        <div class="form-grouph submit-design text-center">
                            <input type="submit" value="Add/Edit Account" class="btn-design-second">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection