@extends('layouts.app')
@section('content')

<section class="home-banner-section" style="background-image: url(assets/images/home-banner.png);">
  <div class="container">
    <div class="homepbanner-content text-center">
      <h2>Finding a Lawyer Just Got Easier</h2>
      <!-- <p class="text_p">Find the best attorney close to and best <a href="#">for you</a></p> -->
      <a href="{{ route('narrow.down') }}" class="btn-banner-design">Find my lawyer</a>
    </div>
  </div>
</section>
<section class="incrediable_services-sec">
  <div class="container">
    <div class="heading-paragraph-design text-center">
      <h2>Most Popular Practice Areas</h2>
      <!-- <p>Amazing savings when you bundle services together.</p> -->
    </div>
    <div class="services-slider-sec">
      <div class="slider service-slider">
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/litigation.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4>Personal Injury (Plaintiff)</h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/divorce.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4>Divorce/Family</h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a> 
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt"> 
            <h4>Wills, Trusts, & Estates</h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/divorce.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4>Criminal Defense (Felony)</h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4>Criminal Defense (Misdemeanor/ Traffic Offenses)</h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>


        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4> Commercial Litigation </h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>

        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4> Landlord/Tenant (Tenant)  </h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4> Class Action/Mass Tort   </h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>

          <div class="service_block-cntnt">
            <h4> Defamation/ Libel/ Slander    </h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
        <div class="service_blocks">
          <div class="service_block-icon">
            <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
          </div>
          <div class="service_block-cntnt">
            <h4> Small Business Contracts     </h4>
            <!-- <p>Est voluptatum placeat est maxime architecto eum.</p> -->
            <a href="#" class="check-price-btn">See Available Lawyers</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center service-practice_link">
      <a href="#">See All Practice Areas</a>
    </div>
  </div>
  </div>
</section>
<section class="rating-section position-relative">
  <div class="rating_container">
    <div class="row">
      <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
        <div class="heading-paragraph-design m-text-center">
          <h2>Providing everyone the opportunity to find a lawyer that fits their needs.</h2>
          <p>We strive to give potential clients the information and tools they need to find the
            best lawyer for their individual goals. We make it easy to filter through lawyers to
            find the right fit and provide the ability to schedule a video consultation with the
            lawyer in order to make an informed decision.</p>
          <div class="five-star-blocks">
            <img src="{{ asset('assets/images/stars.png') }}">
            <img src="{{ asset('assets/images/stars.png') }}">
            <img src="{{ asset('assets/images/stars.png') }}">
            <img src="{{ asset('assets/images/stars.png') }}">
            <img src="{{ asset('assets/images/stars.png') }}">
          </div>
        </div>
      </div>
    </div>
    <div class="rating-slider-sec">
      <div class="slider rating-slider">
        <div class="rating_box">
          <h4 class="quote-icon-text">“</h4>
          <p class="rating-desc">“Our job is to get everyone home safely to their loved ones and working with Prickly Pear helps us to do that.”</p>
          <div class="user-circle_img">
            <img src="{{ asset('assets/images/seth.png') }}">
          </div>
          <h6 class="user-name">Seth Brooks</h6>
        </div>
        <div class="rating_box">
          <h4 class="quote-icon-text">“</h4>
          <p class="rating-desc">“Our job is to get everyone home safely to their loved ones and working with Prickly Pear helps us to do that.”</p>
          <div class="user-circle_img">
            <img src="{{ asset('assets/images/seth.png') }}">
          </div>
          <h6 class="user-name">Seth Brooks</h6>
        </div>
        <div class="rating_box">
          <h4 class="quote-icon-text">“</h4>
          <p class="rating-desc">“Our job is to get everyone home safely to their loved ones and working with Prickly Pear helps us to do that.”</p>
          <div class="user-circle_img">
            <img src="{{ asset('assets/images/seth.png') }}">
          </div>
          <h6 class="user-name">Seth Brooks</h6>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="how-prickly-pear-works">
  <div class="works-container">
    <div class="heading-paragraph-design text-center">
      <h2>How Does Prickly Pear Work?</h2>
      <p>We simplify the process of finding a
        lawyer by narrowing down the options to those that matter most to each potential
        client. First, choose the practice area that best describes your needs. Second, filter
        lawyers by hourly rate, consultation fee, years of experience, and other important
        factors. Finally, book and attend your video consultation to confirm the lawyer is a
        match.</p>
    </div>
    <div class="step-main-sec">
      <div class="steps-flex-wrap d-flex">
        <div class="step first-step">
          <h4>Step 1</h4>
          <img src="{{ asset('assets/images/phone.png') }}">
        </div>
        <div class="step second-step">
          <h4>Step 2</h4>
          <img src="{{ asset('assets/images/phone.png') }}">
        </div>
        <div class="step third-step">
          <h4>Step 3</h4>
          <img src="{{ asset('assets/images/phone.png') }}">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection