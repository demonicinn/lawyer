<div>
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
                                
                                
                                
                                @if ($workingDatesTimeSlot)
                            <ul class="list-unstyled">

                                @foreach($workingDatesTimeSlot as $key => $slot)
                                <li>
                                    <div class="time-selection" >
                                        <input type="radio" value="{{date('h:i A', strtotime($slot['time']))}}" wire:model="selectDateTimeSlot" {{ $slot['is_free']=='no' ? 'disabled' : '' }}>

                                        <button class="time-selection-btn" {{ $slot['is_free']=='no' ? 'disabled' : '' }}>
                                            <i class="fa-regular fa-calendar-check"></i>{{date('h:i A', strtotime($slot['time']))}}
                                        </button>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <h5>Please select the date to show the availability.</h5>
                            @endif

                            {!! $errors->first('selectDateTimeSlot', '<span class="help-block">:message</span>')  !!}

                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                            <div class="form-grouph submit-design text-center">
                                <button type="button" class="btn-design-first" wire:loading.remove wire:click="confirmSlot" wire:loading.attr="disabled">
                                    Confirm
                                </button>

                                <button type="button" wire:loading wire:target="confirmSlot" class="btn-design-first">
                                    <i class="fa fa-spin fa-spinner"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @push('scripts')




    <script>
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
        .day.wrong-month {
            display: none;
        }
    </style>
    @endpush
</div>