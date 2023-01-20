@extends('layouts.app')
@section('content')


<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-3">
            <h2>Account Information</h2>
        </div>
        <div class="user_acc_info-wrapper">
            

            <div class="row">
                <div class="col-md-6 form-design">
                    <div class="white-shadow-scnd-box">

                    
                    <!--<h3>Add New Card</h3>-->
                    <form class="form-design row justify-content-center pb-5" method="post" action="{{route('lawyer.card.store')}}">
                        @csrf

                        <h3 class="pt-2"><b class="h4-design m-0 d-block  pt-3">Add New Card</b></h3>
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



                        <button type="submit" class="btn-design-first btn_bank mt-3">Add Card</button>
                    </form>
                    
                    
                    <h3><b class="h4-design">Saved Cards</b></h3>

                    
                    @php
                        $cards = $user->userCards()->orderBy('id', 'desc')->get();
                    @endphp


                    @foreach($cards as $card)
                    <div class="left_form_3">
                        <div class="form-grouph input-design">
                            <label><b>Card Name</b></label> {{ $card->card_name }}
                        </div>
                        <div class="form-grouph input-design">
                        <label> <b>Card Number</b></label> **** {{ $card->card_number }}
                        </div>
                        <div class="form-grouph input-design">
                            <label><b>Card Type</b></label>
                             {{ $card->card_type }}
                        </div>
                        
                        <div class="d-flex btn_als3">
                        @if($card->is_primary=='0')
                        <form class="form-design" method="post" action="{{route('lawyer.card.primary', $card->id)}}">
                            @csrf
                            <button type="submit" class="btn-design-first btn_bank btn_sr">Set as Primary</button>
                        </form>
                        @else
                        <button type="button" class="btn-design-first btn_bank btn_sr btn_primry" disabled>Primary</button>
                        @endif
                       
    
                        <form class="form-design row justify-content-center " method="post" action="{{route('lawyer.card.remove', $card->id)}}">
                            @csrf
                            <button type="submit" class="btn-design-first btn_bank btn_sr">Remove Card</button>
                        </form>
                     </div>
                     </div>
                    @endforeach
               
    

                    
                    
                    
                </div>
                </div>

                <div class="col-md-6">
                <div class="white-shadow-scnd-box">
                           <h3 class="pt-2"><b class="h4-design m-0 d-block  pt-3">Deposit Information</b></h3>
                        @if(@$record->status=='active')

                            @if($record->payouts_enabled!='active')
                                <div class="alert alert-warning" role="alert">
                                Payouts are not enabled for your account. Please check all the details are verified or not.
                                </div>
                                <a class="btn-design-first btn_bank" href="{{route('lawyer.banking.update')}}">Update Bank Account Details</a>
                                {{--
                                {!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'form-design row justify-content-center']) !!}
                    			<button type="submit" class="btn-design-first btn_bank">Update Bank Account Details</button>
                    			{!! Form::close() !!}
                    			--}}
                            @endif
                            
                            <div class="mt-2"></div>
                            @if(!$record->account_number)
                                <p class="pb-3">Please fill in your bank account information to complete your bank account verification.</p>
                            @endif
                            
                            <form class="form-design row justify-content-center" method="post" action="{{route('lawyer.banking.store')}}">
                                @csrf
                
                                <div class="">
                                <div class="">
                                    <div class="form">
                                        <div class="form-grouph input-design">
                                            <label>Account Holder Name*</label>
                                            {!! Form::text('account_holder_name', @$record->account_holder_name ?? null, ['class' => ($errors->has('account_holder_name') ? ' is-invalid' : '')]) !!}
                                            @error('account_holder_name')<div class="help-block">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-grouph input-design">
                                            <label>Account Number*</label>
                                            {!! Form::text('account_number', @$record->account_number ?? null, ['class' => ($errors->has('account_number') ? ' is-invalid' : '')]) !!}
                                            @error('account_number')<div class="help-block">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-grouph input-design">
                                            <label>Routing Number*</label>
                                            {!! Form::text('routing_number', @$record->routing_number ?? null, ['class' => ($errors->has('routing_number') ? ' is-invalid' : '')]) !!}
                                            @error('routing_number')<div class="help-block">{{ $message }}</div>@enderror
                                        </div>
                
                                    </div>
                                </div>
                                
                                
                                
                                
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-3">
                                        <div class="form-grouph submit-design text-center">
                                            
                                            <input type="submit" value="{{ @$record->account_number ? 'Edit' : 'Add' }} Account" class="btn-design-second">
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            
                        @else
                            {!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'form-design row justify-content-center']) !!}
                			<button type="submit" class="btn-design-first btn_bank">Connect Bank Account</button>
                			{!! Form::close() !!}
                        @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection