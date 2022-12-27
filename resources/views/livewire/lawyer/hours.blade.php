<div>
    <!--new code here-->
    <div class="white-shadow-scnd-box height-auto acnt_info_clnder">
        <div class="form-heading">
            <h4 class="h4-design">Availability</h4>
        </div>
        <div class="availibity-form mt-4" wire:ignore>
            <div class="calendar-container">
                <div id="celender"></div>
            </div>
        </div>
    </div>
    <div class="white-shadow-scnd-box height-auto mt-5 acnt_info_2">
        <div class="form-heading">
            <h4 class="h4-design">Recurrence Rules</h4>
        </div>
        <div class="ref-rules_block">
            
            
            
            <label class="second-label-design">On</label>
            <div class="form-flex seven-columns justify-content-spacebw">
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Sunday" wire:model="weekdays.Sunday">
                    <button class="checkbox-btn">S</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Monday" wire:model="weekdays.Monday">
                    <button class="checkbox-btn">M</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Tuesday" wire:model="weekdays.Tuesday">
                    <button class="checkbox-btn">T</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Wednesday" wire:model="weekdays.Wednesday">
                    <button class="checkbox-btn">W</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Thursday" wire:model="weekdays.Thursday">
                    <button class="checkbox-btn">T</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Friday" wire:model="weekdays.Friday">
                    <button class="checkbox-btn">F</button>
                </div>
                <div class="checkbox-design-2 position-relative">
                    <input type="checkbox" value="Saturday" wire:model="weekdays.Saturday">
                    <button class="checkbox-btn">S</button>
                </div>
                {!! $errors->first('weekdays', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-flex mt-4">
                <div class="form-grouph input-design input-design-2 d-flex align-items-center">
                    <label class="second-label-design w-auto">From</label>
                    <select class="form-grouph select-design" wire:model="from_time">
                        <option value="">Select From Time</option>
                        @foreach($getTime as $ti => $time)
                        <option value="{{ $ti }}">{{ $time }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
                </div>

                <div class="form-grouph input-design input-design-2 d-flex align-items-center">
                    <label class="second-label-design w-auto">To</label>
                    <select class="form-grouph select-design" wire:model="to_time">
                        <option value="">Select To Time</option>
                        @foreach($getTime as $ti => $time)
                        <option value="{{ $ti }}">{{ $time }}</option>
                        @endforeach
                    </select>



                    {!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="accept_rule mt-3 mb-4 text-center">
                <button type="button" class="btn-design-first" wire:click="store">Accept Rule</button>
            </div>
            
            
            
            @if(count($hours)>0)
            <div class="current_rules-sec">
                <div class="form-heading">
                    <h4 class="h4-design">Current Rules</h4>
                </div>
                <div class="current_list_rules">
                    <ul class="list-unstyled">
                        @foreach($hours as $hour)
                        <li>
                            <p>
                                {{ $hour->day ? $hour->days : $hour->date }} from {{ date('h:i A', strtotime($hour->from_time)) }} - {{ date('h:i A', strtotime($hour->to_time)) }}
                            </p>
                            {{--
                            <p><span class="bold week-day">Tuesdays</span> and <span class="bold week-day">Thursdays</span> every <span class="bold week-type">week</span> from <span class="bold time_rule">4:00 pm - 6:30 pm</span></p>
                            --}}

                            <button type="button" class="close_list btn-transparent" wire:click="delete({{$hour->id}})">&times;</button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        </div>
    </div>




    <!-- Accept Modal Start Here-->
    <div wire:ignore.self class="modal fade common_modal modal-design" id="availabilityForm" tabindex="-1" aria-labelledby="availabilityForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <button type="button" class="btn btn-default close closeModal">
                <i class="fas fa-close"></i>
            </button>

                <form>
                    <div class="modal-header modal_h">
                        <h3>Add Availability</h3>
                    </div>
                    <div class="modal-body">
                        <div>
                            <h4>{{ @$newDate ? date('m-d-Y', strtotime($newDate)) : '' }}</h4>
                            <div class="form-grouph select-design">
                                <label>From</label>
                                <select wire:model="from_time">
                                    <option value="">Select From Time</option>
                                    @foreach($getTime as $i => $time)
                                    <option value="{{ $i }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('from_time', '<span class="help-block">:message</span>') !!}
                            </div>
            
                            <div class="form-grouph select-design">
                                <label>To</label>
                                <select wire:model="to_time">
                                    <option value="">Select To Time</option>
                                    @foreach($getTime as $j => $time)
                                    <option value="{{ $j }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('to_time', '<span class="help-block">:message</span>') !!}
                            </div>
                            

                        </div>
                    </div>
                    <div class="text-center mb-3">
                        <button type="button" class="btn-design-first" wire:click="storeAvailability" wire:loading.attr="disabled">
                            <i wire:loading wire:target="storeAvailability" class="fas fa-spin fa-spinner"></i> Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    

    @push('scripts')
    <script>
        initCalender()
    
    
        function initCalender() {

            var container = $("#celender").simpleCalendar({
                //fixedStartDay: 0, // begin weeks by sunday
                disableEmptyDetails: true,
                disableEventDetails: true,
                enableOnlyEventDays: true,

                onMonthChange: function(month, year) {
                    
                },

                onDateSelect: function(date, events) {

                    var dateF = new Date(date);
                    let newDate = dateF.getFullYear() +'-'+ (dateF.getMonth() + 1) + '-' + dateF.getDate();
                    
                    @this.set('newDate', newDate);
                    
                    $('#availabilityForm').modal('show');
                },

            });


            let $calendar = container.data('plugin_simpleCalendar')
            //reinit events


            //$calendar.setEvents(eventArray)


            //console.log('fcdfcdx', $calendar)
        }
        
        $('.closeModal').on('click', function(){
            $('#availabilityForm').modal('hide');
        });
        
        window.livewire.on('availabilityFormClose', () => {
            $('#availabilityForm').modal('hide');
        });
        
        
    </script>
    @endpush

</div>