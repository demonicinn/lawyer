
<div class="lawyer_profile-wrapper">
    <div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		    <div class="white-shadow-scnd-box">
		        <div class="form-heading">
		            <h4 class="h4-design">Add Bank Details</h4>
		        </div>

				{!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'lawyer_profile-information form-design']) !!}

				<button type="submit" class="btn-design-first">Connect Bank Account</button>

				{!! Form::close() !!}

		    </div>
		</div>
    </div>
</div>