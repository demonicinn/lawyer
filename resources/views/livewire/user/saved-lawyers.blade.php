<div>

    <div class="user_saved-lawyers_inner">
        <div class="user-saved_filter-sec">
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

                    <div class="form-grouph input-design icon-input-design right-icn-design">
                        <input type="search" wire:model="search" placeholder="Search">
                        <span class="input_icn"><i class="fa-solid fa-magnifying-glass"></i></span>
                    </div>
                    <div class="form-grouph input-design icon-input-design right-icn-design mt-1">
                        <a class="btn clear-btn" wire:click="clear">Clear</a>
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
                                <h4 class="lawyer-name">{{$lawyer->lawyer->first_name}} {{$lawyer->lawyer->last_name}}</h4>
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
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i>{{ @$lawyer->lawyerInfo->items->name }}</p>
                            <div class="location_profile-divs d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i> {{ @$lawyer->lawyer->details->city }}, {{ @$lawyer->lawyer->details->states->code }}</address>
                                <a href="{{ route('lawyer.show', $lawyer->lawyer->id)}}">See Profile</a>
                            </div>
                            @php $lawyerID= Crypt::encrypt($lawyer->lawyer->id); @endphp
                            <div class="schedular_consultation">

                                <a href="{{route('schedule.consultation',$lawyerID)}}" class="schule_consultation-btn">Schedule Consultation</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <h4>No Lawyers Found</h4>
                @endforelse
            </div>
        </div>

        <div id="pagination-container" class="pagination-container-saved">{{$lawyers->links()}}</div>
    </div>
</div>