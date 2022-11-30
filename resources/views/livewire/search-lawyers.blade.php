<div>
    <div class="lawyer-service-list-sec d-flex flex-wrap">
        <div id="filter-sidebar" class="sidebar-wrap">
            <form class="form-design">
                <div class="filter-sidebar">
                    <h4>Filter by:</h4>


                    <div class="hourly-range-design range-design mb-5">
                        <h5 class="h5-design">Hourly Rate</h5>
                        <div class="slider-area" wire:ignore>
                            <div class="slider-area-wrapper">
                                <p class="min-value">${{$rate_min}}</p>
                                <div id="hourlyRange" class="slider"></div>
                                <p class="max-value">${{$rate}}</p>
                            </div>
                        </div>
                    </div>


                    <div class="toggle-design-wrapper d-flex flex-wrap align-items-center mb-4 justify-content-spacebw">
                        <h5 class="h5-design">Free Consultation</h5>
                        <div class="toggle-design_div">
                            <input type="checkbox" wire:model="free_consultation"  name="free-consultation">
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


                    <div class="hourly-range-design range-design mb-5">
                        <h5 class="h5-design">Years Experience</h5>
                        <div class="slider-area" wire:ignore>
                            <div class="slider-area-wrapper">
                                <p class="min-value">{{$year_exp_min}}</p>
                                <div id="yearsRange" class="slider"></div>
                                <p class="max-value">{{$year_exp}}+</p>
                            </div>
                        </div>
                    </div>


                    {{--
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
                    --}}


                    <div class="hourly-range-design range-design mb-5">
                        <h5 class="h5-design">Distance</h5>
                        <div class="slider-area" wire:ignore>
                            <div class="slider-area-wrapper">
                                <p class="min-value">{{$distance_min}}mi</p>
                                <div id="distanceRange" class="slider"></div>
                                <p class="max-value">{{$distance}}+mi</p>
                            </div>
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

                @forelse($lawyers as $lawyer)
                <div class="list-item list-service-item">
                    <div class="lawyer-hire-block">
                        @if(@$lawyer->profile_pic)
                        <div class="lawyers-img-block border-10">
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
                            @if(@$lawyer->details->school_attendent)
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->details->school_attendent }}</p>
                            @endif
                            <div class="location_profile-divs border-bottom pb-2 d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->details->city }}, {{ @$lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->id) }}?type={{ $search_type }}&search={{ json_encode($search_data) }}">See Profile</a>
                            </div>

                            <div class="add-litigations mt-2 location_profile-divs d-flex justify-content-spacebw align-items-center border-bottom pb-2">
                                <button type="button" class="btn_court btn_adm showModal " wire:click="modalData({{$lawyer->id}})"><i class="fa-solid fa-gavel"></i>Admissions</button>
                               {{--<a href="{{ route('lawyer.show', $lawyer->id) }}?type={{ $search_type }}&search={{ json_encode($search_data) }}">See Profile</a>--}} 
                            </div>
                            <div class="practice_area_div">
                             <div class="left_trash">
                                 <span>PRACTICE AREA</span>
                                 <h5>{{ $practice_area }}</h5>
                             </div>


                             {{--
                             <div class="right_trash">
                                <a href="#" class="trash_link"><i class="fa-regular fa-trash-can"></i></a>
                             </div>
                             --}}

                            </div>

                            @php $lawyerID = Crypt::encrypt($lawyer->id); @endphp
                            
                            @if(auth()->check())
                            @if(auth()->user()->role=='user')
                            <div class="schedular_consultation">
                                <a href="{{route('schedule.consultation', $lawyerID)}}?type={{ $search_type }}&search={{ json_encode($search_data) }}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                            @endif
                            @else
                            <div class="schedular_consultation">
                                <a href="{{route('schedule.consultation', $lawyerID)}}?type={{ $search_type }}&search={{ json_encode($search_data) }}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                            @endif


                        </div>
                    </div>
                </div>
                @empty
                <h4>No lawyers found</h4>
                @endforelse



                @if($modal)
                <!-- Accept Modal Start Here-->
                <div wire:ignore.self class="modal fade courts_modal common_modal modal-design fedral_court_modal court_modal" id="courtModal" tabindex="-1" aria-labelledby="courtModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <button type="button" class="btn btn-default close closeModal">
                            <i class="fas fa-close"></i>
                        </button>

                            <div class="modal-header modal_h">

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  @if($modal->lawyerInfo)
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Federal Court Admissions</button>
                                  </li>
                                  @endif

                                  @if($modal->lawyerStateBar)
                                  <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ !$modal->lawyerInfo ? 'active' : '' }}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">State Bar Admissions</button>
                                  </li>
                                  @endif
                                </ul>

                            </div>
                            <div class="modal-body">

                                <div class="tab-content" id="myTabContent">
                                    @if($modal->lawyerInfo)
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        @foreach ($modal->lawyerInfo as $lawyerInfo)
                                        <div class="mb-4 courts_data">
                                           <div class="name_data_p">
                                             <h6>{{ @$lawyerInfo->items->name }}</h6>
                                            {{--<p class="mb-0">{{ @$lawyerInfo->items->category->name }} {{ @$lawyerInfo->items->category->mainCat->name ? ' - '.$lawyerInfo->items->category->mainCat->name : ''  }}</p>--}}
                                           </div>
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
                                        @endforeach
                                    </div>
                                    @endif

                                    @if($modal->lawyerStateBar)
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        @foreach ($modal->lawyerStateBar as $item)
                                        <div class="mb-4 courts_data">
                                           <div class="name_data_p">
                                             <h6>{{ @$item->statebar->name }}</h6>
                                           </div>
                                            <div class="federal-court">
                                                <div class="form-grouph select-design">
                                                    <label>Bar Number</label>
                                                    <div>{{ @$item->bar_number ?? '--' }}</div>
                                                </div>
                                                <div class="form-grouph select-design">
                                                    <label>Year Admitted</label>
                                                    <div>{{ $item->year_admitted ?? '--'}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Accept Modal Close Here-->
                @endif


                <div id="pagination-container" class="pagination-container-service">
                    {!! $lawyers->links() !!}
                </div>
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
            
            
            //...
            
            $(function() {
                var hourlyRange = document.getElementById("hourlyRange");
                noUiSlider.create(hourlyRange, {
                    start: [{{$rate_min}}, {{$rate}}],
                    connect: true,
                    behaviour: "drag",
                    tooltips: true,
                    step: 10,
                    range: {
                        min: 0,
                        max: 1000
                    },
                    format: {
                        from: function (value) {
                            var from = parseInt(value);
                            return from;
                        },
                        to: function (value) {
                            var to = parseInt(value);
                            return "$"+to;
                        }
                    }
                });
                
                
                hourlyRange.noUiSlider.on('change', function (values){
                    
                        var from = parseInt(values[0].replace("$", ""));
                        var to = parseInt(values[1].replace("$", ""));
                        @this.set('rate_min', from);
                        @this.set('rate', to);
                    
                });
            });
            
            
            
            
            
            
            
            
            
            
            
            $(function() {
                var yearsRange = document.getElementById("yearsRange");
                noUiSlider.create(yearsRange, {
                    start: [{{$year_exp_min}}, {{$year_exp}}],
                    connect: true,
                    behaviour: "drag",
                    tooltips: true,
                    step: 1,
                    range: {
                        min: 1,
                        max: 20
                    },
                    format: {
                        from: function (value) {
                            var from = parseInt(value);
                            return from;
                        },
                        to: function (value) {
                            var to = parseInt(value);
                            return to+" yrs";
                        }
                    }
                });
                
                yearsRange.noUiSlider.on('change', function (values){
                        var from = parseInt(values[0].replace(" yrs", ""));
                        var to = parseInt(values[1].replace(" yrs", ""));
                    
                        @this.set('year_exp_min', from);
                        @this.set('year_exp', to);
                    
                });
            });
            
            
            $(function() {
                var distanceRange = document.getElementById("distanceRange");
                noUiSlider.create(distanceRange, {
                    start: [{{$distance_min}}, {{$distance}}],
                    connect: true,
                    behaviour: "drag",
                    tooltips: true,
                    step: 5,
                    range: {
                        min: 1,
                        max: 100
                    },
                    format: {
                        from: function (value) {
                            var from = parseInt(value);
                            return from;
                        },
                        to: function (value) {
                            
                            var to = parseInt(value);
                            return to+" miles";
                        }
                    },
                });
                
                
                distanceRange.noUiSlider.on('change', function (values){
                        var from = parseInt(values[0].replace(" miles", ""));
                        var to = parseInt(values[1].replace(" miles", ""));
                    
                        @this.set('distance_min', from);
                        @this.set('distance', to);
                    
                });
            });
            
            
            

        </script>
        @endpush
    </div>