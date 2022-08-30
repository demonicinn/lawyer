<div>


    @if(@$clickConfirm)
    <section class="body-banner per-info-page-sec min-height-100vh">
        <div  class="container">
            <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
                <h2>Booking Information</h2>
            </div>
            <div class="personal-information-wrapper">
                <!-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                    <div class="form-grouph submit-design text-center">
                        <a class="btn-design-first" wire:click="backbtn">go back</a>
                    </div>
                </div> -->
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
                                    <div class="booking-info-left_column">
                                        <img src="{{ $lawyerDetails->profile_pic }}">
                                    </div>
                                    <div class="booking-info-right_column">
                                        <h4 class="booking_name">{{$lawyerDetails->first_name}} {{$lawyerDetails->last_name}}</h4>
                                        <h5 class="booking_type-text">Admiralty/Maritime</h5>
                                        <p class="booking_date-time">{{$avaibleTime }} <span class="divider-horizonatl"></span> {{$scheduletime}}</p>
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

    @elseif($shedulePage)


    <section class="body-banner schdule-consultation-page-sec min-height-100vh">
        <div  class="container">
            <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
                <h2>Schedule a Consultation</h2>
            </div>

            <div class="schedule_consultation-wrapper">
                <form class="schedule-form-design">
                    <div class="row">

                        <div wire:ignore class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div  id="celender" class="calendar-container"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div id="events-data">
                                <h4 class="event-date">
                                    <p>{{$avaibleTime}}</p>
                                </h4>
                                @if ($lawyer !=null)
                                <ul class="list-unstyled">

                                    @foreach ($timeSlots as $key => $time)
                                    <li>
                                        <div class="time-selection">
                                            <input type="radio" value="{{date('h:i A', strtotime($time))}}" id="rent" name="type" wire:model="scheduletime"><button class="time-selection-btn"><i class="fa-regular fa-calendar-check"></i>{{date('h:i A', strtotime($time))}}</button>
                                        </div>

                                    </li>


                                    @endforeach



                                </ul>
                                {!! $errors->first('scheduletime', '<span class="help-block">:message</span>') !!}
                                @else
                                <h5>Oops! slot not available.</h5>
                                @endif

                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                            <div class="form-grouph submit-design text-center">
                                <a class="btn-design-first" wire:click="confirm()">Confirm</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @endif


    @push('scripts')
    <script>
        var $calendar;
        $(document).ready(function() {

            let container = $("#celender").simpleCalendar({
                fixedStartDay: 0, // begin weeks by sunday
                disableEmptyDetails: true,
                disableEventDetails: true,


                events: [
                    // generate new event after tomorrow for one hour
                    {
                        startDate: new Date(new Date().setHours(new Date().getHours() + 24)).toDateString(),
                        endDate: new Date(new Date().setHours(new Date().getHours() + 25)).toISOString(),
                        summary: 'Visit of the Eiffel Tower'
                    },
                    // generate new event for yesterday at noon
                    {
                        startDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 12, 0)).toISOString(),
                        endDate: new Date(new Date().setHours(new Date().getHours() - new Date().getHours() - 11)).getTime(),
                        summary: 'Restaurant'
                    },
                    // generate new event for the last two days
                    {
                        startDate: new Date(new Date().setHours(new Date().getHours() - 48)).toISOString(),
                        endDate: new Date(new Date().setHours(new Date().getHours() - 24)).getTime(),
                        summary: 'Visit of the Louvre'
                    }
                ],

                onDateSelect: function(date, events) {
                    // alert(date);
                    // $t = date('d-m-Y', strtotime(date))
                    // alert($t);
                    @this.set('selDate', date);
                },

            });


            $calendar = container.data('plugin_simpleCalendar')



        });
    </script>
    @endpush
</div>