<div>

    <div class="user_saved-lawyers_inner">
        <div class="user-saved_filter-sec">
            <form class="form-design">
                <div class="d-flex justify-content-spacebw">
                    <div class="form-grouph select-design select-design-2 d-flex">
                        <label>Filter by:</label>
                        <select>
                            <option>Practice Areas</option>
                        </select>
                    </div>
                    <div class="form-grouph input-design icon-input-design right-icn-design">
                        <input type="search" placeholder="Search">
                        <span class="input_icn"><i class="fa-solid fa-magnifying-glass"></i></span>
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
                            <img src="assets/images/hallie.png">
                        </div>
                        <div class="lawyers-service-cntnt-block">
                            <div class="lawyers-heading_service d-flex justify-content-spacebw align-items-center">
                                <h4 class="lawyer-name">{{$lawyer->lawyer->first_name}}  {{$lawyer->lawyer->last_name}}</h4>
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
                            <p class="school_name"><i class="fa-solid fa-school-flag"></i> Harvard Law School</p>
                            <div class="location_profile-divs d-flex justify-content-spacebw align-items-center">
                                <address><i class="fa-solid fa-location-dot"></i>  {{ @$lawyer->lawyer->details->city }}, {{ @$lawyer->lawyer->details->states->code }}</address>
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

                <h4>No Saved Lawyers</h4>

                @endforelse

            </div>
            <div id="pagination-container" class="pagination-container-saved">
        
            </div>
        </div>
    </div>
</div>