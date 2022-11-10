@extends('layouts.app')
@section('content')


<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-3">
            <h2>Account Information</h2>
        </div>
        <div class="user_acc_info-wrapper">
            

            <div class="row">
                <div class="col-md-6">
                    <b>Card for Subscription</b>
                    
                    @php
                        $card = $user->userCards()->orderBy('id', 'desc')->first();
                    @endphp

                    @if(@$card)
                    <p>Card Name: {{ $card->card_name }}</p>
                    <p>Card Number: **** {{ $card->card_number }}</p>
                    <p>Card Type: {{ $card->card_type }}</p>

                    <form class="form-design row justify-content-center" method="post" action="{{route('lawyer.card.remove')}}">
                        @csrf
                        <button type="submit" class="btn-design-first btn_bank">Remove Card</button>
                    </form>
                    @else
                    <form class="form-design row justify-content-center" method="post" action="{{route('lawyer.card.store')}}">
                        @csrf


                        <div class="billing-info_form-inputs">

                            <div class="form-grouph input-design{!! ($errors->has('card_name') ? ' has-error' : '') !!}">
                                {!! Form::label('card_name', 'Name on Card', ['class' => 'form-label']) !!}
                                {!! Form::text('card_name', null, ['class' => ($errors->has('card_name') ? ' is-invalid' : '')]) !!}
                                {!! $errors->first('card_name', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-grouph input-design{!! ($errors->has('card_number') ? ' has-error' : '') !!}">
                                {!! Form::label('card_number', 'Card Number', ['class' => 'form-label']) !!}
                                {!! Form::number('card_number', null, ['class' => ($errors->has('card_number') ? ' is-invalid' : '')]) !!}
                                {!! $errors->first('card_number', '<span class="help-block">:message</span>') !!}
                            </div>



                            <div class="form-flex three-columns">
                                <div class="form-grouph input-design">
                                    <label>Expiration Month</label>
                                    <select name="expire_month" class="form-control" placeholder="Exp Month">
                                        <option value="">Select Month</option>
                                        @for ($i = 1; $i <=12; $i++)
                                        <option value="{{ $i<=9 ? '0'.$i : $i }}">{{ date('F', mktime(0,0,0,$i)) }}</option>
                                        @endfor
                                    </select>
                                    {!! $errors->first('expire_month', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-grouph input-design">
                                    <label>Expiration Year</label>
                                    <select name="expire_year" class="form-control" placeholder="Expiration Year">
                                        <option value="">Select Year</option>
                                        @for ($i = 0; $i <10; $i++)
                                        @php $year = date('Y') + $i; @endphp
                                        <option value="{{$year}}">{{$year}}</option>
                                        @endfor
                                    </select>
                                    {!! $errors->first('expire_year', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-grouph input-design">
                                    <label>CVV</label>
                                    <input type="number" placeholder="CVV" name="cvv">
                                    {!! $errors->first('cvv', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>



                            </div>



                        <button type="submit" class="btn-design-first btn_bank">Add Card</button>
                    </form>
                    @endif

                </div>

                <div class="col-md-6">


                    @if(@$record)
                        @if(@$bankInfo->status=='active')
                            @if(!$record->account_number)
                                <p class="text-center pb-3">Please fill the bank account to complete your bank account verification.</p>
                            @endif
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
                                            
                                            <input type="submit" value="{{ @$record->account_number ? 'Edit' : 'Add' }} Account" class="btn-design-second">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            {!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'form-design row justify-content-center']) !!}
                			<button type="submit" class="btn-design-first btn_bank">Connect Bank Account</button>
                			{!! Form::close() !!}
                        @endif
                    @else
                        {!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'form-design row justify-content-center']) !!}
            			<button type="submit" class="btn-design-first btn_bank">Connect Bank Account</button>
            			{!! Form::close() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection