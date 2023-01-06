<div>

    @if(@$currentTab=='tab1')
    @include('livewire.consultation.time-slot')
    @endif

    @if(@$currentTab=='tab2')
    @include('livewire.consultation.booking')
    @endif


    @push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <script>


        let workingDates = @json(@$workingDates);

        $(document).ready(function() {

            $(document).on('click', '.loginModalShow', function(){
                $('#loginForm').modal('show');
            });
            $(document).on('click', '.closeLoginModal', function(){
                $('#loginForm').modal('hide');
            });


            window.livewire.on('phoneMask', () => {
                $('.phone').inputmask('(999)-999-9999');
            });
            $('.phone').inputmask('(999)-999-9999');

            getDates(workingDates);

            window.livewire.on('fireCalender', (dates) => {
                getDates(dates);
            });
            window.livewire.on('loginFormClose', () => {
                $('#loginForm').modal('hide');
            });
            window.livewire.on('unCheckRadiobtn', () => {

                $('.checkedbtn').prop('checked', false);
                @this.set('paymentDetails', true);
               
            });
            window.livewire.on('scrollUp', () => {
                $(window).scrollTop(0);
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
                },

                onDateSelect: function(date, events) {
                    
                    var dateF = new Date(date);
                    let newDate = (dateF.getMonth() + 1) + '/' + dateF.getDate() + '/' + dateF.getFullYear();

                    @this.set('selectDate', newDate);
                    @this.set('clicked', '1');
                    
                    
                    @this.set('selectDateTimeSlot', '');
                },

            });


            let $calendar = container.data('plugin_simpleCalendar')
            //reinit events


            $calendar.setEvents(eventArray)


            //console.log('fcdfcdx', $calendar)
        }

    </script>

    <style>
        .day.wrong-month {
            display: none;
        }
        
        .loading {
            position: fixed;
            width: 100%;
            height: 100%;
            content: "";
            background-color: #9d9b9bad;
            top: 0;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #ff0000;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            animation: spin 2s linear infinite;
            position: fixed;
            z-index: 999;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        #celender .day.active {
            background: #A4CAA5 !important;
            border-radius: 4px;
            color: #fff !important;
            border: none;
        }
    </style>
    @endpush
</div>