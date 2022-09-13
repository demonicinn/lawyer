<div>

    @if(@$currentTab=='tab1')
    @include('livewire.consultation.time-slot')
    @endif

    @if(@$currentTab=='tab2')
    @include('livewire.consultation.booking')
    @endif


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