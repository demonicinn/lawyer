
<div class="lawyer_profile-wrapper">
    <div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		    <div class="white-shadow-scnd-box">
		        <div class="form-heading">
		            <h4 class="h4-design">Add Bank Details</h4>
		        </div>

		        {{--
				{!! Form::open(['route' => 'lawyer.profile.bank', 'class'=>'lawyer_profile-information form-design']) !!}
		        <div class="form-flex">
		            <div class="form-grouph input-design{!! ($errors->has('account_number') ? ' has-error' : '') !!}">
		                {!! Form::label('account_number','Account Number', ['class' => 'form-label']) !!}    
		                {!! Form::text('account_number', null, ['class' => ($errors->has('account_number') ? ' is-invalid' : '')]) !!}
		                {!! $errors->first('account_number', '<span class="help-block">:message</span>') !!}
		            </div>
		            <div class="form-grouph input-design{!! ($errors->has('routing_number') ? ' has-error' : '') !!}">
		                {!! Form::label('routing_number','Routing Number', ['class' => 'form-label']) !!}    
		                {!! Form::text('routing_number', null, ['class' => ($errors->has('routing_number') ? ' is-invalid' : '')]) !!}
		                {!! $errors->first('routing_number', '<span class="help-block">:message</span>') !!}
		            </div>
		            <div class="form-grouph input-design{!! ($errors->has('account_holder_name') ? ' has-error' : '') !!}">
		                {!! Form::label('account_holder_name','Account Holder Name', ['class' => 'form-label']) !!}    
		                {!! Form::text('account_holder_name', null, ['class' => ($errors->has('account_holder_name') ? ' is-invalid' : '')]) !!}
		                {!! $errors->first('account_holder_name', '<span class="help-block">:message</span>') !!}
		            </div>
		        </div>


				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
		            <div class="form-grouph submit-design text-center">
		                <button type="submit" class="btn-design-first">Save Bank</button>
		            </div>
		        </div>

		        {!! Form::close() !!}
		        --}}


				{!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'lawyer_profile-information form-design']) !!}

				<button type="submit" class="btn-design-first">Connect Bank Account</button>

				{!! Form::close() !!}

		    </div>
		</div>
    </div>
</div>