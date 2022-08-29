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
                            <div id="celender" class="calendar-container"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div id="events-data">
                                <h4 class="event-date">
                                    <p>{{$avaibleTime}}</p>
                                </h4>

                                <ul class="list-unstyled">
                                    <li>
                                        <div class="time-selection">
                                            <input type="radio" name="time">
                                            <button class="time-selection-btn"><i class="fa-regular fa-calendar-check"></i>{{date('h:i A', strtotime($lawyer->from_time))}}</button>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="time-selection">
                                            <input type="radio" name="time">
                                            <button class="time-selection-btn"><i class="fa-regular fa-calendar-check"></i> {{date('h:i A', strtotime($lawyer->to_time))}}</button>
                                           
                                        </div>
                                    </li>

                                </ul>
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

    @push('scripts')
    <script>
        var $calendar;
        $(document).ready(function() {

            let container = $("#celender").simpleCalendar({
                fixedStartDay: 0, // begin weeks by sunday
                disableEmptyDetails: true,
                disableEventDetails: true,
                titleFormat: { // will produce something like "Tuesday, September 18, 2018"
                    month: 'numeric',
                    year: 'numeric',
                    day: 'numeric',
                    weekday: 'numeric'
                },
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
                    alert(date);
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