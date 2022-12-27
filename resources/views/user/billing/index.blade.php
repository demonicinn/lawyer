@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('user') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Portal</a>
        </div>
		
		
        <div class="row justify-content-center">
			<div class="col-md-8 form-design">
				<div class="white-shadow-scnd-box">
					
                    
                    <!--<h3>Add New Card</h3>-->
                    <form class="form-design row justify-content-center pb-5" method="post" action="{{route('user.billing.store')}}">
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
		</div>
		
		
	</div>
</section>
@endsection