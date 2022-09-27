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
                                <p>{{@$dateFormat}}</p>
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
                            <h5>Oops! Slot not available.</h5>
                            @endif

                            {!! $errors->first('selectDateTimeSlot', '<span class="help-block">:message</span>')  !!}

                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mt-5">
                        <div class="form-grouph submit-design text-center">
                            <button type="button" class="btn-design-first" wire:click="confirmSlot" wire:loading.attr="disabled">
                                <i wire:loading wire:target="confirmSlot" class="fa fa-spin fa-spinner"></i> Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>