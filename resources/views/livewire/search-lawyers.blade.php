<div>
    <div class="lawyer-service-list-sec d-flex flex-wrap">
        <div id="filter-sidebar" class="sidebar-wrap">
            <form class="form-design">
                <div class="filter-sidebar">
                    <h4>Filter by:</h4>
                    <div class="hourly-range-design range-design mb-5">
                        <h5 class="h5-design">Hourly Rate</h5>
                        <div class="n-slider" wire:ignore>
                            <!-- <p class="min-value">$0</p> -->
                            <input type="text" id="hourlyRange" readonly>
                            <div id="hourly-range" class="slider"></div>
                            <!-- <p class="max-value">$500</p> -->
                        </div>
                        
                        {{--
                        <div class="range-wrapper position-relative">
                            <p class="min-value">$0</p>
                            <div id="hourly-rate-slider" class="range-slider">
                                <div id="hourly-range" class="tooltip-range"></div>
                                <input class="range_design-input" type="range" step="10" wire:model="rate" title="{{$rate}}" min="0" max="500">
                            </div>
                            <p class="max-value">$500</p>
                        </div>
                        --}}
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

                    <div class="year-exp-design range-design mb-5">
                        <h5 class="h5-design">Years Experience</h5>
                        
                        <div class="n-slider" wire:ignore>
                            <!-- <p class="min-value">1</p> -->
                            <input type="text" id="yearsRange" readonly>
                            <div id="years-range" class="slider"></div>
                            <!-- <p class="max-value">20</p> -->
                        </div>
                        
                        {{--
                        <div class="range-wrapper position-relative">
                            <p class="min-value">1</p>
                            <div id="years-experience-slider" class="range-slider">
                                <div id="experience-range-tooltip" class="tooltip-range"></div>
                                <input wire:model="year_exp" class="range_design-input" type="range" step="1" min="0" max="20" title="{{$year_exp}}">
                                <input wire:model="year_exp" class="range_design-input" type="range" step="1" min="0" max="20" title="{{$year_exp}}">
                            </div>
                            <p class="max-value">20</p>
                        </div>
                        --}}
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
                        <div class="n-slider" wire:ignore>
                            <!-- <p class="min-value">1 mi</p> -->
                            <input type="text" id="distanceRange" readonly>
                            <div id="distance-range" class="slider"></div>
                            <!-- <p class="max-value">100 mi</p> -->
                        </div>
                        
                        {{--
                        <div class="range-wrapper position-relative">
                            <p class="min-value">1 mi</p>
                            <div id="distance-range-slides" class="range-slider">
                                <div class="tooltip-range"></div>
                                <input class="range_design-input" wire:model="distance" type="range" step="1" min="0" max="100" title="{{$distance}}">
                            </div>
                            <p class="max-value">100 mi</p>
                        </div>
                        --}}
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
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->lawyerCategory->items->name }}</p>
                            <div class="location_profile-divs border-bottom pb-2 d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->details->city }}, {{ @$lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->id) }}?type={{ $search_type }}&search={{ json_encode($search_data) }}">See Profile</a>
                            </div>

                            <div class="add-litigations mt-2 location_profile-divs d-flex justify-content-spacebw align-items-center border-bottom pb-2">
                                <button type="button" class="btn_court btn_adm showModal " wire:click="modalData({{$lawyer->id}})"><i class="fa-solid fa-gavel"></i>  Admissions</button>
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
                <div wire:ignore.self class="modal fade courts_modal common_modal modal-design fedral_court_modal" id="courtModal" tabindex="-1" aria-labelledby="courtModal" aria-hidden="true">
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
                                            <p class="mb-0">{{ @$lawyerInfo->items->category->name }} {{ @$lawyerInfo->items->category->mainCat->name ? ' - '.$lawyerInfo->items->category->mainCat->name : ''  }}</p>
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
                $("#hourly-range").slider({
                    step: 5,
                    range: true, 
                    min: 0, 
                    max: 500, 
                    values: [0, 500], 
                    slide: function(event, ui)
                    {
                        $("#hourlyRange").val(ui.values[0] + " - " + ui.values[1]);
                        
                        @this.set('rate_min', ui.values[0]);
                        @this.set('rate', ui.values[1]);
                    }
                });
                
                $("#hourlyRange").val($("#hourly-range").slider("values", 0) + " - " + $("#hourly-range").slider("values", 1));
            
            });
            
            
            $(function() {
                $("#years-range").slider({
                    step: 1,
                    range: true, 
                    min: 1, 
                    max: 20, 
                    values: [1, 20], 
                    slide: function(event, ui)
                    {
                        $("#yearsRange").val(ui.values[0] + " - " + ui.values[1]);
                        
                        @this.set('year_exp_min', ui.values[0]);
                        @this.set('year_exp', ui.values[1]);
                    }
                });
                
                $("#yearsRange").val($("#years-range").slider("values", 0) + " - " + $("#years-range").slider("values", 1));
            
            });
            
            
            $(function() {
                $("#distance-range").slider({
                    step: 1,
                    range: true, 
                    min: 0, 
                    max: 100, 
                    values: [0, 100], 
                    slide: function(event, ui)
                    {
                        $("#distanceRange").val(ui.values[0] + " - " + ui.values[1]);
                        
                        @this.set('distance_min', ui.values[0]);
                        @this.set('distance', ui.values[1]);
                    }
                });
                
                $("#yearsRange").val($("#distance-range").slider("values", 0) + " - " + $("#distance-range").slider("values", 1));
            
            });
            
            

        </script>
        @endpush
    </div>