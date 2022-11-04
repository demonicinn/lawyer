@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>{{ @$title['title'] }}</h2>
            <a href="{{ route('user.billing.index') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Go Back</a>
        </div>

        
        <div class="user_payment-wrapper-inner">

          {!! Form::open(['route' => 'user.billing.store', 'class'=>' form-design']) !!}
            <div class="white-shadow-scnd-box">
              <div class="form-heading">
                <h4 class="h4-design">Billing Information</h4>
              </div>
              <div class="billing-info_form-inputs">

              	<div class="form-grouph input-design{!! ($errors->has('card_name') ? ' has-error' : '') !!}">
	                {!! Form::label('card_name', 'Name on Card', ['class' => 'form-label']) !!}
	                {!! Form::text('card_name', null, ['class' => ($errors->has('card_name') ? ' is-invalid' : '')]) !!}
	                {!! $errors->first('card_name', '<span class="help-block">:message</span>') !!}
	            </div>

	            <div class="form-grouph input-design{!! ($errors->has('card_number') ? ' has-error' : '') !!}">
	                {!! Form::label('card_number', 'Card Numbe', ['class' => 'form-label']) !!}
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
            </div>
          <div class="row mt-3">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
              <div class="form-grouph submit-design text-center">
                <input type="submit" value="Add Payment Information" class="btn-design-third">
              </div>
            </div>
          </div>
          </form>
        </div>


      
    </div>
</section>
@endsection