@extends('layouts.app')
@section('content')
<section class="home-banner-section" style="background-image: url(assets/images/home-banner.png);">
  <div class="container">
     <div class="homepbanner-content text-center">
      <h2>Finding Lawyers Just Got Easier.</h2>
      <p>Find the best attorney, close to and best <a class="pa-design" href="#">for you.</a></p>
      <a href="{{ route('narrow.down') }}" class="btn-banner-design">Find my attorney</a>
     </div>
  </div>
 </section>
 <section class="incrediable_services-sec">
  <div class="container">
    <div class="heading-paragraph-design text-center">
      <h2>Incredible Services. Great Price.</h2>
      <p>Amazing savings when you bundle services together.</p>
    </div>
    <div class="services-slider-sec">
      <div class="slider service-slider">
          <div class="service_blocks">
            <div class="service_block-icon">
              <img src="{{ asset('assets/images/services/litigation.svg') }}">
            </div>
            <div class="service_block-cntnt">
              <h4>Litigation</h4>
              <p>Est voluptatum placeat est maxime architecto eum.</p>
              <a href="#" class="check-price-btn">Check Our Prices</a>
            </div>
          </div>
          <div class="service_blocks">
            <div class="service_block-icon">
              <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
            </div>
            <div class="service_block-cntnt">
              <h4>Car Accident</h4>
              <p>Est voluptatum placeat est maxime architecto eum.</p>
              <a href="#" class="check-price-btn">Check Our Prices</a>
            </div>
          </div>
          <div class="service_blocks">
            <div class="service_block-icon">
              <img src="{{ asset('assets/images/services/divorce.svg') }}">
            </div>
            <div class="service_block-cntnt">
              <h4>Divorce</h4>
              <p>Est voluptatum placeat est maxime architecto eum.</p>
              <a href="#" class="check-price-btn">Check Our Prices</a>
            </div>
          </div>
          <div class="service_blocks">
            <div class="service_block-icon">
              <img src="{{ asset('assets/images/services/car-acceident.svg') }}">
            </div>
            <div class="service_block-cntnt">
              <h4>Car Accident</h4>
              <p>Est voluptatum placeat est maxime architecto eum.</p>
              <a href="#" class="check-price-btn">Check Our Prices</a>
            </div>
          </div>
          <div class="service_blocks">
            <div class="service_block-icon">
              <img src="{{ asset('assets/images/services/divorce.svg') }}">
            </div>
            <div class="service_block-cntnt">
              <h4>Divorce</h4>
              <p>Est voluptatum placeat est maxime architecto eum.</p>
              <a href="#" class="check-price-btn">Check Our Prices</a>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center service-practice_link">
         <a href="#">Sell All Practice Areas</a>
      </div>
    </div>
  </div>
 </section>
 <section class="rating-section position-relative">
   <div class="rating_container">
      <div class="row">
         <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
           <div class="heading-paragraph-design m-text-center">
            <h2>We give them five star service, they trust us.</h2>
            <p>Lorem ipsum dolor sit amet. Et impedit similique et quibusdam quia est rerum eaque. Voluptatem eligendi est dicta adipisci sed voluptas deserunt.</p>
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
        <h2>How Prickly Pear Works?</h2>
        <p>Lorem ipsum dolor sit amet. Et impedit similique et quibusdam quia est rerum eaque. Voluptatem eligendi est dicta adipisci sed voluptas deserunt.</p>
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