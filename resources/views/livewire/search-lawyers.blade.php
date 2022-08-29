<div>
    <div class="lawyer-service-list-sec d-flex flex-wrap">
        <div id="filter-sidebar" class="sidebar-wrap">
            <form class="form-design">
                <div class="filter-sidebar">
                    <h4>Filter by:</h4>
                    <div class="hourly-range-design range-design mb-5">
                        <h5 class="h5-design">Hourly Rate</h5>
                        <div class="range-wrapper position-relative">
                            <p class="min-value">$0</p>
                            <div id="hourly-rate-slider" class="range-slider">
                                <div id="hourly-range" class="tooltip-range"></div>
                                <input id="range" class="range_design-input" type="range" step="10" value="200" min="0" max="500">
                            </div>
                            <p class="max-value">$500</p>
                        </div>
                    </div>
                    <div class="toggle-design-wrapper d-flex flex-wrap align-items-center mb-4 justify-content-spacebw">
                        <h5 class="h5-design">Free Consultation</h5>
                        <div class="toggle-design_div">
                            <input id="free-consultation" type="checkbox" wire:model="free_consultation" name="free-consultation">
                            <button class="cstm-toggle-btn"></button>
                        </div>
                    </div>
                    <div class="toggle-design-wrapper d-flex flex-wrap align-items-center mb-4 justify-content-spacebw">
                        <h5 class="h5-design">Contingency Cases</h5>
                        <div class="toggle-design_div">
                            <input id="contingency-cases" type="checkbox" wire:model="contingency_cases" name="contingency-cases" >
                            <button class="cstm-toggle-btn"></button>
                        </div>
                    </div>
                    <div class="year-exp-design range-design mb-5">
                        <h5 class="h5-design">Years Experience</h5>
                        <div class="range-wrapper position-relative">
                            <p class="min-value">1</p>
                            <div id="years-experience-slider" class="range-slider">
                                <div id="experience-range-tooltip" class="tooltip-range"></div>
                                <input id="experience-range" wire:model="year_exp" class="range_design-input" type="range" step="1" value="15" min="1" max="50">
                            </div>
                            <p class="max-value">20+</p>
                        </div>
                    </div>


                    <div class="form-group select-design form-grouph mb-4">

                        @foreach ($categories as $category)
                        @if ($category->items_count)
                        <div class="form-grouph input-design">
                            
                            <label> {{ $category->name }}*</label>
                          
                        </div>
                        <select name="lawyer_info[{{$category->id}}]" required>

                            @foreach($category->items as $i => $list)

                            <option value="{{$list->id}}">
                                {{$list->name}}
                            </option>
                          
                            @endforeach

                        </select>
                        @endif
                        @endforeach


                    </div>
                    <div class="distance-within-design range-design form-grouph mb-5">
                        <h5 class="h5-design">Within Distance</h5>
                        <div class="range-wrapper position-relative">
                            <p class="min-value">1 mi</p>
                            <div id="distance-range-slides" class="range-slider">
                                <div id="distance-range-tooltip" class="tooltip-range"></div>
                                <input id="distance-range" class="range_design-input" type="range" step="1" value="15" min="1" max="200">
                            </div>
                            <p class="max-value">100+ mi</p>
                        </div>
                    </div>
                    <div class="form-group input-design form-grouph icon-input-design dark-placehiolder">
                        <input type="search" placeholder="Location">
                        <span class="input_icn"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>
            </form>
        </div>


        <div class="lawyers-list-sec">
            <div class="list-wrapper list-service">

                @foreach($lawyers as $lawyer)
                <div class="list-item list-service-item">
                    <div class="lawyer-hire-block">
                        <div class="lawyers-img-block">
                            <img src="{{ $lawyer->profile_pic }}">
                        </div>
                        <div class="lawyers-service-cntnt-block">
                            <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                <h4 class="lawyer-name">{{ $lawyer->name }}</h4>
                                <button class="hire-price-btn">${{ @$lawyer->details->hourly_fee }}/hr.</button>
                            </div>
                            <div class="lawyers-desc_service d-flex justify-content-spacebw">
                                <div class="years_experience_div">
                                    <p>YEARS EXP.</p>
                                    <h4>{{ @$lawyer->details->year_experience }}</h4>
                                </div>
                                <div class="contingency-cases_div">
                                    <p>CONTINGENCY CASES</p>
                                    <h4>{{ @ucfirst($lawyer->details->contingency_cases) }}</h4>
                                </div>
                                <div class="consult-fee_div">
                                    <p>CONSULT FEE</p>
                                    <h4>{{ @$lawyer->details->is_consultation_fee=='yes' ? '$'.$lawyer->details->consultation_fee : 'Free' }}</h4>
                                </div>
                            </div>
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i> Harvard Law School</p>
                            <div class="location_profile-divs d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->details->city }}, {{ @$lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->id) }}">See Profile</a>
                            </div>

                            @php $lawyerID= Crypt::encrypt($lawyer->id); @endphp
                            <div class="schedular_consultation">
                                <a href="{{route('schedule.consultation',$lawyerID)}}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach




                <div id="pagination-container" class="pagination-container-service"></div>
            </div>
        </div>
    </div>