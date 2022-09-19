<section class="body-banner per-info-page-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Booking Information</h2>
        </div>


        <div class="personal-information-wrapper">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                <div class="form-grouph submit-design text-center">
                    <button type="button" class="btn-design-first" wire:click="backbtn">go back</button>
                </div>
            </div>
            <form class="personal-form-information form-design">

                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                        <div class="white-shadow-scnd-box">
                            <div class="form-heading">
                                <h5 class="h5-design">Information about you</h5>
                                <div class="already_have-account">

                                    @if(!Auth::check())
                                    <a data-bs-toggle="modal" data-bs-target="#loginForm" style="text-decoration: underline;">
                                        Already have an account?
                                    </a>
                                    @endif

                                </div>

                                <!--Login Modal -->
                                <div wire:ignore.self class="modal fade" id="loginForm" tabindex="-1" aria-labelledby="loginFormLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="loginFormLabel">Login</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="authentication-container">
                                                        <div class="authentication-header">
                                                            <h2>User Login</h2>
                                                        </div>
                                                        @if(Session::has('error'))
                                                        <p class="alert alert-info">{{ Session::get('error') }}</p>
                                                        @endif
                                                        <div class="lawyer-login">

                                                            <div class="white-shadow-box">


                                                                <div class="form-grouph input-design">
                                                                    <input type="email" wire:model="uemail" placeholder="Enter email">
                                                                    {!! $errors->first('uemail', '<span class="help-block">:message</span>') !!}
                                                                </div>

                                                                <div class="form-grouph input-design">
                                                                    <input type="password" wire:model="upassword" placeholder="Enter password">
                                                                    {!! $errors->first('upassword', '<span class="help-block">:message</span>') !!}
                                                                </div>
                                                                <div class="form-grouph submit-design text-center">
                                                                    <a style="text-decoration: none;" class="form-btn" wire:click="login">{{__ ('Login') }}</a>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="form-grouph input-design">
                                <label>First Name*</label>
                                <input type="text" wire:model='first_name' placeholder="First Name" value="">
                                {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph input-design">
                                <label>Last Name*</label>
                                <input type="text" wire:model='last_name' placeholder="Last Name">
                                {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph input-design">
                                <label>Phone</label>
                                <input type="number" wire:model='phone' placeholder="Phone Number (optional)">
                                {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-grouph input-design">
                                <label>Email*</label>
                                <input type="email" wire:model='email' placeholder="Email">
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>

                            @if(!Auth::check())

                            <div class="form-grouph input-design">
                                <label>Password*</label>
                                <input type="password" wire:model='password' placeholder="Password">
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-grouph input-design">
                                <label>Confirm Password*</label>
                                <input type="password" wire:model='password_confirmation' placeholder="Confirm Password">
                                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                            </div>
                            @endif



                        </div>
                    </div>
                 
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                        <div class="white-shadow-scnd-box booking-info_profile">
                            <div class="booking-info_profile-flex">
                                @if(@$lawyer->profile_pic)
                                <div class="booking-info-left_column">
                                    <img src="{{ $lawyer->profile_pic }}">
                                </div>
                                @endif
                                <div class="booking-info-right_column">
                                    <h4 class="booking_name">{{ $lawyer->name }}</h4>
                                    <div class="row">

                                        <div class="col-md-8">
                                            <label class="booking_type-text">Litigations </label>
                                            @foreach ($litigations as $litigation )
                                            <p >{{$litigation->name}}</p>
                                            @endforeach
                                        </div>

                                        <div class="col-md-4">
                                            <label class="booking_type-text">Contracts</label>
                                            @foreach ($contracts as $contract )
                                            <p >{{$contract->name}}</p>
                                            @endforeach
                                        </div>


                                    </div>

                                    <p class="booking_date-time">{{ $selectDate }} <span class="divider-horizonatl"></span> {{ $selectDateTimeSlot }}</p>

                                </div>
                            </div>

                            <div class="white-shadow-scnd-box mt-4">
                                @if($this->lawyer->details->is_consultation_fee == "yes")
                                <div class="form-heading">
                                    <h5 class="h5-design">Payment Details</h5>
                                </div>
                                <div class="form-grouph input-design">
                                    <label>Name on Card*</label>
                                    <input type="text" placeholder="Name on Card" wire:model="card_name">
                                    {!! $errors->first('card_name', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-grouph input-design">
                                    <label>Card Number*</label>
                                    <input type="number" placeholder="Credit card number" wire:model="card_number">
                                    {!! $errors->first('card_number', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class="form-flex three-columns">

                                    <div class="form-grouph input-design">
                                        <label>Expiration Month*</label>

                                        <select wire:model="expire_month" class="form-control" placeholder="Exp Month">
                                            <option value="">Select Month</option>
                                            @for ($i = 1; $i <=12; $i++) <option value="{{ $i<=9 ? '0'.$i : $i }}">{{ date('F', mktime(0,0,0,$i)) }}</option>
                                                @endfor
                                        </select>
                                        {!! $errors->first('expire_month', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-grouph input-design">
                                        <label>Expiration Year*</label>


                                        <select wire:model="expire_year" placeholder="Expiration Year">
                                            <option value="">Select Year</option>
                                            @for ($i = 0; $i <10; $i++) @php $year=date('Y') + $i; @endphp <option value="{{$year}}">{{$year}}</option>
                                                @endfor
                                        </select>
                                        {!! $errors->first('expire_year', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="form-grouph input-design">
                                        <label>CVV*</label>
                                        <input type="number" placeholder="CVV" wire:model="cvv">
                                        {!! $errors->first('cvv', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                @else
                                <h4>Free Consultation</h4>
                                @endif

                                <div class="charge_text">
                                    <p>We will charge you <a href="#" class="pa-design">after</a> your consultation.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                            <button type="button" class="btn-design-first" wire:loading.remove wire:click="saveUserInfoAndBooking" wire:loading.attr="disabled">
                                Confirm Booking
                            </button>
                            <button class="btn-design-first" wire:loading wire:target="saveUserInfoAndBooking">
                                <i class="fa fa-spin fa-spinner"></i>
                            </button>
                        </div>


                    </div>
            </form>
        </div>
    </div>


</section>