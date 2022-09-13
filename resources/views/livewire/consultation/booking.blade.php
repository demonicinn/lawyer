<section class="body-banner per-info-page-sec min-height-100vh">
    <div  class="container">
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
                                    <a href="#">Already have an account?</a>
                                </div>
                            </div>

                            <div class="form-grouph input-design">
                                <label>First Name*</label>
                                <input type="text" placeholder="First Name" value="">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Last Name*</label>
                                <input type="text" placeholder="Last Name">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Phone</label>
                                <input type="number" placeholder="Phone Number (optional)">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Email*</label>
                                <input type="email" placeholder="Email">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Password*</label>
                                <input type="password" placeholder="Password">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Confirm Password*</label>
                                <input type="password" placeholder="Confirm Password">
                            </div>
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
                                    <h5 class="booking_type-text">Admiralty/Maritime</h5>
                                    <p class="booking_date-time">{{ $selectDate }} <span class="divider-horizonatl"></span> {{ $selectDateTimeSlot }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="white-shadow-scnd-box mt-4">
                            <div class="form-heading">
                                <h5 class="h5-design">Payment Details</h5>
                            </div>
                            <div class="form-grouph input-design">
                                <label>Name on Card*</label>
                                <input type="text" placeholder="Name on Card">
                            </div>
                            <div class="form-grouph input-design">
                                <label>Card Number*</label>
                                <input type="number" placeholder="Credit card number">
                            </div>
                            <div class="form-flex three-columns">
                                <div class="form-grouph input-design">
                                    <label>Zip Code*</label>
                                    <input type="number" placeholder="Zip Code">
                                </div>
                                <div class="form-grouph input-design">
                                    <label>Expiration Date*</label>
                                    <input type="date" placeholder="Exp Date">
                                </div>
                                <div class="form-grouph input-design">
                                    <label>CVV*</label>
                                    <input type="number" placeholder="CVV">
                                </div>
                            </div>
                            <div class="charge_text">
                                <p>We will charge you <a href="#" class="pa-design">after</a> your consultation.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                        <div class="form-grouph submit-design text-center">
                            <input type="submit" value="Save" class="btn-design-first">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>