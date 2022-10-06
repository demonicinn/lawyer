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
                                <input class="range_design-input" type="range" step="10" wire:model="rate" min="0" max="500">
                            </div>
                            <p class="max-value">$500</p>
                        </div>
                    </div>

                    <div class="toggle-design-wrapper d-flex flex-wrap align-items-center mb-4 justify-content-spacebw">
                        <h5 class="h5-design">Free Consultation</h5>
                        <div class="toggle-design_div">
                            <input type="checkbox" wire:model="free_consultation" name="free-consultation">
                            <button class="cstm-toggle-btn"></button>
                        </div>
                    </div>

                    <div class="toggle-design-wrapper d-flex flex-wrap align-items-center mb-4 justify-content-spacebw">
                        <h5 class="h5-design">Contingency Cases</h5>
                        <div class="toggle-design_div">
                            <input id="contingency-cases" type="checkbox" wire:model="contingency_cases" name="contingency-cases">
                            <button class="cstm-toggle-btn"></button>
                        </div>
                    </div>

                    <div class="year-exp-design range-design mb-5">
                        <h5 class="h5-design">Years Experience</h5>
                        <div class="range-wrapper position-relative">
                            <p class="min-value">1</p>
                            <div id="years-experience-slider" class="range-slider">
                                <div id="experience-range-tooltip" class="tooltip-range"></div>
                                <input wire:model="year_exp" class="range_design-input" type="range" step="1" min="0" max="20">
                            </div>
                            <p class="max-value">20</p>
                        </div>
                    </div>

                    <div class="form-group select-design form-grouph mb-4">
                        @foreach ($categories as $category)
                        @if ($category->items_count)
                        <div class="form-grouph input-design">
                            <label> {{ $category->name }}*</label>
                        </div>
                        <select wire:model="category.{{$category->id}}">
                            <option value="">Select {{ $category->name }}</option>
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
                                <div class="tooltip-range"></div>
                                <input class="range_design-input" wire:model="distance" type="range" step="1" min="0" max="100">
                            </div>
                            <p class="max-value">100 mi</p>
                        </div>
                    </div>

                    <div class="form-group input-design form-grouph icon-input-design dark-placehiolder">
                        <input type="search" wire:model.debounce.500ms="search" placeholder="Search">
                        <span class="input_icn"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                </div>
            </form>
        </div>


        <div class="lawyers-list-sec">
            <div class="list-wrapper list-service">

<<<<<<< HEAD
                @forelse($lawyers as $lawyer)
=======
                @if(count($lawyers)>0)
                @foreach($lawyers as $lawyer)
>>>>>>> 83e9f901848287b0a6698f6bee5178f0ebcd1c31
                <div class="list-item list-service-item">
                    <div class="lawyer-hire-block">
                        @if(@$lawyer->profile_pic)
                        <div class="lawyers-img-block">
                            <img src="{{ $lawyer->profile_pic }}">
                        </div>
                        @endif
                        <div class="lawyers-service-cntnt-block">
                            <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                <h4 class="lawyer-name">{{ @$lawyer->name }}</h4>
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
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->lawyerCategory->items->name }}</p>
                            <div class="location_profile-divs d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->details->city }}, {{ @$lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->id) }}">See Profile</a>
                            </div>

                            <div class="add-litigations">
                                <button type="button" class="accept_btn showModal mt-2" wire:click="modalData({{$lawyer->id}})">Courts</button>
                            </div>

                            @php $lawyerID= Crypt::encrypt($lawyer->id); @endphp
                            <div class="schedular_consultation">
                                <a href="{{route('schedule.consultation',$lawyerID)}}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD

                @empty
                <h4>No lawyers found</h4>
                @endforelse
=======
                @endforeach
                @else
                <p>No lawyers found</p>
                @endif


>>>>>>> 83e9f901848287b0a6698f6bee5178f0ebcd1c31


                @if($modal)
                <!-- Accept Modal Start Here-->
                <div wire:ignore.self class="modal fade" id="courtModal" tabindex="-1" aria-labelledby="courtModal" aria-hidden="true">
                    <div class="modal-dialog modal_style">
                        <button type="button" class="btn btn-default close closeModal">
                            <i class="fas fa-close"></i>
                        </button>
                        <div class="modal-content">
                            <form>
                                <div class="modal-header modal_h">
                                    <h3>Courts</h3>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        @foreach ($modal->lawyerInfo as $lawyerInfo)
                                        @if($lawyerInfo->categories->is_multiselect)
                                        <div class="mb-4">
                                            <h6>{{ @$lawyerInfo->items->name }}</h6>
                                            <p class="mb-0">{{ @$lawyerInfo->items->category->name }} {{ @$lawyerInfo->items->category->mainCat->name ? ' - '.$lawyerInfo->items->category->mainCat->name : ''  }}</p>
                                            <div class="federal-court">
                                                <div class="form-grouph select-design">
                                                    <label>Bar Number</label>
                                                    <div>{{ @$lawyerInfo->bar_number ?? '--' }}</div>
                                                </div>
                                                <div class="form-grouph select-design">
                                                    <label>Year Admitted</label>
                                                    <div>{{ $lawyerInfo->year_admitted ?? '--'}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Accept Modal Close Here-->
                @endif
                <div id="pagination-container" class="pagination-container-service"></div>
            </div>
        </div>

        @push('scripts')
        <script>
            $(document).ready(function() {

                window.livewire.on('courtModalShow', () => {
                    $('#courtModal').modal('show');
                });
            });
            $(document).on('click', '.showModal', function(e) {
                $('#courtModal').modal('show');
            });
            $(document).on('click', '.closeModal', function(e) {
                $('#courtModal').modal('hide');
            });
        </script>
        @endpush
    </div>