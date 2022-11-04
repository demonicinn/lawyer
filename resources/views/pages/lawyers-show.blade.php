@extends('layouts.app')
@section('content')
<section class="body-banner lawyer-directory-profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Directory Profile</h2>
            <a href="{{ url()->previous() ?? route('narrow.down') }}" class="go-back"><i class="fa-solid fa-arrow-left-long"></i> Back to Lawyers</a>
        </div>
        <div class="directory-profile-wrapper">
            <form class="directory-form-information form-design">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="white-shadow-third-box">
                            <div class="lawyer-hire-block">
                                <div class="lawyers-img-block">
                                    <img src="{{ $user->profile_pic }}">
                                </div>
                                <div class="lawyers-service-cntnt-block">
                                    <div class="lawyers-heading_service d-block justify-content-spacebw align-items-center directory_h4_btn">
                                        <h4 class="lawyer-name text-center">{{ @$user->name }}</h4>
                                        <button class="hire-price-btn">${{ @$user->details->hourly_fee }}/hr.</button>
                                    </div>
                                    <div class="lawyers-desc_service d-flex justify-content-spacebw">
                                        <div class="years_experience_div">
                                            <p>YEARS EXP.</p>
                                            <h4>{{ @$user->details->year_experience }}</h4>
                                        </div>
                                        <div class="contingency-cases_div">
                                            <p>CONTINGENCY CASES</p>
                                            <h4>{{ @ucfirst($user->details->contingency_cases) }}</h4>
                                        </div>
                                        <div class="consult-fee_div">
                                            <p>CONSULT FEE</p>
                                            <h4>{{ @$user->details->is_consultation_fee=='yes' ? '$'.$user->details->consultation_fee : 'Free' }}</h4>
                                        </div>
                                    </div>
                                    <p class="school_name"><i class="fa-solid fa-school-flag"></i> Harvard Law School</p>
                                    <div class="location_profile-divs school_name border-bottom px-0 pb-2">
                                        <address><i class="fa-solid fa-location-dot"></i> {{ @$user->details->city }}, {{ @$user->details->states->code }}</address>
                                    </div>

                                    <div class="add-litigations mt-2 location_profile-divs d-flex justify-content-spacebw align-items-center ">
                                <button type="button" class="btn_court showModal "><i class="fa-solid fa-gavel"></i>  Admission</button>
                              <!--   <a href="#">See Profile</a> -->
                            </div>


                                    <!-- <div class="add-litigations">
                                        <button type="button" class="accept_btn showModal mt-2">Courts</button>
                                    </div> -->

                                    @php $lawyerID= Crypt::encrypt($user->id); @endphp

                                    @if(auth()->check())
                                    @if(auth()->user()->role=='user')
                                    <div class="schedular_consultation">
                                        <a href="{{route('schedule.consultation', $lawyerID)}}?type={{ request()->type }}&search={{ request()->search }}" class="schule_consultation-btn">Schedule Consultation</a>
                                    </div>
                                    @endif
                                    @else
                                    <div class="schedular_consultation">
                                        <a href="{{route('schedule.consultation', $lawyerID)}}?type={{ request()->type }}&search={{ request()->search }}" class="schule_consultation-btn">Schedule Consultation</a>
                                    </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                        <div class="white-shadow-third-box lawyer-directory_about-block">
                            <div class="grey-light-heading">
                                <h4>About {{ @$user->name }}</h4>
                            </div>
                            <div class="lawyer_profile-description">
                                {!! @$user->details->bio !!}

                                @if(Auth::check())
                                    @php
                                        $savedLawyer = auth()->user()->savedLawyer->pluck('lawyer_id')->toArray();
                                        //dd($savedLawyer);
                                    @endphp
                                    @if(in_array($user->id, $savedLawyer))
                                    <div class="save_btn text-center">
                                        <a href="{{route('user.lawyer.remove', $lawyerID)}}" class="btn-design-first" title="Already Saved">Remove Attorney</a>
                                    </div>
                                    @else
                                    <div class="save_btn text-center">
                                        <a href="{{route('user.save.lawyer',$lawyerID)}}" class="btn-design-first">Save Attorney</a>
                                    </div>
                                    @endif
                                @else
                                <div class="save_btn text-center">
                                    <a href="{{route('login')}}?redirect=true" class="btn-design-first">Save Attorney</a>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@section('script')
<div class="modal fade courts_modal common_modal modal-design" id="courtModal" tabindex="-1" aria-labelledby="courtModal" aria-hidden="true">
    <div class="modal-dialog modal_style">
        <div class="modal-content">
        <button type="button" class="btn btn-default close closeModal">
            <i class="fas fa-close"></i>
        </button>
            <form>
                <div class="modal-header modal_h">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      @if($user->lawyerInfo)
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Federal Court Admissions</button>
                      </li>
                      @endif

                      @if($user->lawyerStateBar)
                      <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$user->lawyerInfo ? 'active' : '' }}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">State Bar Admissions</button>
                      </li>
                      @endif
                    </ul>

                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        @if($user->lawyerInfo)
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @foreach ($user->lawyerInfo as $lawyerInfo)
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

                        @if($user->lawyerStateBar)
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @foreach ($user->lawyerStateBar as $item)
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

<script>
    $('.showModal').on('click', function(){
        $('#courtModal').modal('show');
    });
    $('.closeModal').on('click', function(){
        $('#courtModal').modal('hide');
    });



</script>
@endsection