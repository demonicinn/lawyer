<div class="reshedule_wrap-box">
    <span class="info_icns"><i class="fa-solid fa-circle-info"></i></span>
    <p>Resheduling consultation will hurt your ratings</p>
    <div class="d-flex">
        <button type="button" class="accept_btn showModal">Confirm</button>

        <a class="cancel_dropdown-btn cancel_btn">Cancel</a>
    </div>
</div>

<!-- Accept Modal Start Here-->
<div wire:ignore.self class="modal fade" id="rescheduleForm" tabindex="-1" aria-labelledby="rescheduleForm" aria-hidden="true">
    <div class="modal-dialog modal_style">
        <button type="button" class="btn btn-default close closeModal">
            <i class="fas fa-close"></i>
        </button>
        <div class="modal-content">
            <form>

                <div class="modal-body reschedulebooking">
                    <section class="body-banner schdule-consultation-page-sec min-height-100vh">
                        <div class="container">
                            <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-4">
                                <h2>Schedule a Consultation</h2>
                            </div>
                            <div class="schedule_consultation-wrapper">
                                <form class="schedule-form-design">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                            <div wire:ignore class="calendar-container">
                                                <div id="celender"></div>
                                            </div>

                                            {!! $errors->first('selectDate', '<span class="help-block">:message</span>') !!}
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                            <div id="events-data">
                                                <h4 class="event-date">
                                                    <p>{{$dateFormat}}</p>
                                                </h4>


                                                @if(count($workingDatesTimeSlot) >0)
                                             
                                               
                                                <ul class="list-unstyled">

                                                    @foreach($workingDatesTimeSlot as $key => $time)
                                               
                                                    <li>

                                                        <div class="time-selection">

                                                            <button class="time-selection-btn">
                                                                <i class="fa-regular fa-calendar-check"></i>{{date('h:i A', strtotime($time))}}
                                                            </button>
                                                        </div>

                                                    </li>
                                                    @endforeach
                                                </ul>
                                                {!! $errors->first('selectDateTimeSlot', '<span class="help-block">:message</span>') !!}
                                                @else
                                                <h5>Oops! Slot not available.</h5>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                                            <div class="form-grouph submit-design text-center">
                                                <a href="personal-booking-information.html" class="btn-design-first">Confirm</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- Accept Modal Close Here-->
@push('scripts')
<script>
    $(document).ready(function() {
        window.livewire.on('rescheduleFormClose', () => {
            $('#rescheduleForm').modal('hide');
        });
        window.livewire.on('rescheduleFormShow', () => {
            $('#rescheduleForm').modal('show');
        });
    });
    $(document).on('click', '.showModal', function(e) {
        $('#rescheduleForm').modal('show');
    });
    $(document).on('click', '.closeModal', function(e) {
        $('#rescheduleForm').modal('hide');
    });



    let workingDates = @json(@$workingDates);

    $(document).ready(function() {

        getDates(workingDates);

        window.livewire.on('fireCalender', (dates) => {
            getDates(dates);
        });
    });


    function getDates(workingDates) {
        let newEvents = [];

        $.each(workingDates, function(i, date) {
            var map = [];
            map['startDate'] = date;
            map['endDate'] = date;

            //...
            newEvents.push(map);
        });

        //...
        initCalender(newEvents)
    }

    function initCalender(eventArray) {

        var container = $("#celender").simpleCalendar({
            //fixedStartDay: 0, // begin weeks by sunday
            disableEmptyDetails: true,
            disableEventDetails: true,
            enableOnlyEventDays: true,

            onMonthChange: function(month, year) {
                @this.set('month', month + 1);
                @this.set('year', year);
                @this.set('selectDate', '');
                @this.set('selectDateTimeSlot', '');
                @this.set('dateFormat', '');
            },

            onDateSelect: function(date, events) {

                var dateF = new Date(date);
                let newDate = (dateF.getMonth() + 1) + '/' + dateF.getDate() + '/' + dateF.getFullYear();

                @this.set('selectDate', newDate);
                @this.set('selectDateTimeSlot', '');
            },

        });


        let $calendar = container.data('plugin_simpleCalendar')
        //reinit events
        $calendar.setEvents(eventArray)
    }

    $(document).ready(function() {
        window.livewire.on('loginFormClose', () => {
            $('#loginForm').modal('hide');
        });

    });
</script>
<style>
    .modal-dialog.modal_style {
        max-width: 1200px;
    }

    .day.wrong-month {
        display: none;
    }

    .reschedulebooking table {
        min-width: auto !important;
    }
</style>
@endpush