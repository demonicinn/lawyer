
<div class="lawyer_profile-wrapper">
    <div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
		    <div class="white-shadow-scnd-box">
		        <div class="form-heading">
		            <h4 class="h4-design">Bank Details</h4>
		        </div> 

		                    @if(@$user->bankInfo && $user->bankInfo->status=='active')
            					@php
            						$bankInfo = $user->bankInfo;
            					@endphp
            					<b>Your Account is Connected.</b>
            					<p><strong>Account Holder Name:</strong> {{ @$bankInfo->account_holder_name }}</p>
            					<p><strong>Account Number:</strong> {{ @$bankInfo->account_number }}</p>
            					<p><strong>Routing Number:</strong> {{ @$bankInfo->routing_number }}</p>
            
            					<a href="{{ route('lawyer.banking.success') }}" class="btn-design-first btn_bank">Edit Bank Account</a>
            					
            				@else	
            					{!! Form::open(['route' => 'lawyer.bank.connect', 'class'=>'lawyer_profile-information form-design']) !!}
            
            					<button type="submit" class="btn-design-first btn_bank">Connect Bank Account</button>
            
            					{!! Form::close() !!}
            				
              				@endif
		    </div>
		</div>
    </div>
</div>