@php
    $message = 'Monthly/Yearly Payment Plans';
@endphp
<div>
    <div class="billing_account-wrapper form-design">
        <form>


            @if(@$currentPlan)
            @php
                $message = 'Upgrade Payment Plans';
            @endphp
            <div class="alert alert-warning">
                <p>Current Subscription Plan <strong>{{ $currentPlan->subscription->name }}</strong></p>
                <p>Expires on: <strong>{{ $currentPlan->to_date }}</strong></p>

                @if(@$user->auto_renew=='1')
                <button type="button" class="btn-design-first" wire:click="removeSubscription">Remove Subscription</button>
                @else
                <button type="button" class="btn-design-first">Subscription Removed</button>
                @endif
            </div>
            @endif


            <div class="row">

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="white-shadow-scnd-box">
                        <div class="form-heading mb-4">
                            <h4 class="h4-design">{{ @$message }}</h4>
                        </div>
                        <div class="payment_plans">

                            @foreach($subscriptions as $subscription)
                            <div class="payment_plans-inner position-relative">
                                <input type="radio" value="{{ $subscription->id }}" name="subscription" wire:click="setSubscription('{{$subscription->id}}', '{{$subscription->type}}')">
                                <div class="payemnt_selection-box">
                                    <h4>{{ $subscription->name }}</h4>
                                    @if(@$subscription->price)
                                    <h5>${{ $subscription->price }}{{ $subscription->types }}</h5>
                                    @endif
                                </div>
                                <span class="payment_confirmation-form"><i class="fa-solid fa-check"></i></span>
                                
                                @if(@$subscription->type=='yearly' && $subscriptionMonthly > 0)
                                <span class="price_saving-tag">${{ $subscriptionMonthly - $subscription->price }} Savings</span>
                                @endif


                            </div>
                            @endforeach
                            
                            {!! $errors->first('subscription', '<span class="help-block">:message</span>') !!}

                            @if(!$currentPlan)
                            <p>You will be on {{ env('FREE_SUBSCRIPTION') }} days trial after that you will get charged based on your plan selection if you have not canceled your plan</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if($type != 'free')
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="white-shadow-scnd-box">
                        <div class="form-heading">
                            <h4 class="h4-design">Billing Information</h4>
                        </div>
                        <div class="billing-info_form-inputs">
                            <div class="form-grouph input-design">
                                <label>Name on Card</label>
                                <input type="text" placeholder="Name on Card" wire:model="card_name">
					            {!! $errors->first('card_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph input-design">
                                <label>Card Number</label>
                                <input type="number" maxlength="16" placeholder="Credit Card Number" wire:model="card_number">
					            {!! $errors->first('card_number', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-flex">
                                <div class="form-grouph select-design">
                                    <label>Expiration Month</label>
                                    <select wire:model="expire_month">
                                        <option value="">Select Month</option>
                                        @for ($i = 1; $i <=12; $i++)
                                        <option value="{{ $i<=9 ? '0'.$i : $i }}">{{ date('F', mktime(0,0,0,$i)) }}</option>
                                        @endfor
                                    </select>
					                {!! $errors->first('expire_month', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-grouph select-design">
                                    <label>Expiration Year</label>
                                    <select wire:model="expire_year">
                                        <option value="">Select Year</option>
                                        @for ($i = 0; $i <10; $i++)
                                        @php $year = date('Y') + $i; @endphp
                                        <option value="{{$year}}">{{$year}}</option>
                                        @endfor
                                    </select>
                                    {!! $errors->first('expire_year', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-grouph input-design">
                                    <label>CVV </label>
                                    <input type="number" maxlength="4" placeholder="CVV" wire:model="cvv">
					                {!! $errors->first('cvv', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <div class="form-grouph submit-design text-center">
                        <button type="button" class="btn-design-first" wire:click="store" wire:loading.attr="disabled">
                            <i wire:loading wire:target="store" class="fa fa-spin fa-spinner"></i> Confirm
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>