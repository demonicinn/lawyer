<div>

    <div class="user_saved-lawyers_inner">
        <div class="user-saved_filter-sec pb-5">
            <form class="form-design">
                <div class="d-flex justify-content-spacebw">
                    <div class="form-grouph select-design select-design-2 d-flex">
                        <label>Practice:</label>
                        <select wire:model="practiceArea">
                            <option value="" selected>Practice Area</option>
                            <option value="Litigations">Litigations</option>
                            <option value="Contracts">Contracts</option>
                        </select>

                    </div>

                    @if (!empty($practices))
                    <div class="form-grouph select-design select-design-2 d-flex">
                        <label>Area:</label>
                        <select wire:model="areaId">
                            <option value="" selected disabled>{{$practiceArea}}</option>
                            @foreach ($practices as $practice)
                            <option value="{{$practice->id}}">{{$practice->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                  <div class="d-flex justify-content-center"> 
                    <div class="form-grouph input-design icon-input-design right-icn-design">
                        <input type="search" wire:model="search" placeholder="Search">
                        <span class="input_icn"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                    <div class="form-grouph input-design icon-input-design right-icn-design mt-1">
                        <a class="btn clear-btn" wire:click="clear">Clear</a>
                    </div>
                  </div>

                </div>
            </form>

        </div>

        <div class="user_saved-lawyers_list">
            <div class="list-wrapper list-wrapper-saved four-layout">


                @forelse ($lawyers as $lawyer)
                <div class="list-item list-item-saved">
                    <div class="lawyer-hire-block">
                        <div class="lawyers-img-block">
                            <img src="{{ $lawyer->lawyer->profile_pic }}">
                        </div>
                        <div class="lawyers-service-cntnt-block">
                            <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                <h4 class="lawyer-name">{{$lawyer->lawyer->name}}</h4>
                                <button class="hire-price-btn">${{$lawyer->lawyer->details->hourly_fee}}/hr.</button>

                            </div>
                            <div class="lawyers-desc_service d-flex justify-content-spacebw">
                                <div class="years_experience_div">
                                    <p>YEARS EXP.</p>
                                    <h4>{{$lawyer->lawyer->details->year_experience}}</h4>
                                </div>
                                <div class="contingency-cases_div">
                                    <p>CONTINGENCY CASES</p>
                                    <h4>{{$lawyer->lawyer->details->contingency_cases}}</h4>
                                </div>
                                <div class="consult-fee_div">
                                    <p>CONSULT FEE</p>
                                    <h4>${{$lawyer->lawyer->details->consultation_fee}}</h4>
                                </div>
                            </div>
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->lawyerCategory->items->name }}</p>
                            <div class="location_profile-divs d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->lawyer->details->city }}, {{ @$lawyer->lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->lawyer->id)}}?type={{ $lawyer->type }}&search={{ $lawyer->data }}">See Profile</a>
                            </div>
                            @php $lawyerID= Crypt::encrypt($lawyer->lawyer->id); @endphp


                            <div class="add-litigations">
                                <button type="button" class="btn_court showModal mt-2" wire:click="modalData({{$lawyer->lawyer->id}})"><i class="fa-solid fa-gavel"></i> Admission</button>
                            </div>
                            <div class="schedular_consultation">

                                <a href="{{route('schedule.consultation', $lawyerID)}}?type={{ $lawyer->type }}&search={{ $lawyer->data }}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                            @php
                                $tdate = date('Y-m-d');

                                $date2week = \Carbon\Carbon::parse($tdate)->add(14, 'days')->format('Y-m-d');

                                $checkAv = $lawyer->lawyer->leave()->where('date', '>=', $tdate)
                                        ->where('date', '<=', $date2week)
                                        ->count();

                            @endphp
                            @if(@$checkAv=='14')
                            <p class="alt info">This lawyer is not available within two weeks</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <h4>No Lawyers Found</h4>
                @endforelse


            </div>
        </div>

        @if($modal)
        <!-- Accept Modal Start Here-->
        <div wire:ignore.self class="modal fade courts_modal common_modal modal-design" id="courtModal" tabindex="-1" aria-labelledby="courtModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <button type="button" class="btn btn-default close closeModal">
                    <i class="fas fa-close"></i>
                </button>
                <div class="modal-content">
                    <form>
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
                    </form>
                </div>
            </div>
        </div>
        <!-- Accept Modal Close Here-->
        @endif

        <div id="pagination-container" class="pagination-container-saved">{{$lawyers->links()}}</div>
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