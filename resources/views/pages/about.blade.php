@extends('layouts.app')
@section('content')
<section class="about-banner-sec " style="background-image: url('{{ asset('assets/images/home-banner.png') }}');">
  <div class="container">
     <div class="homepbanner-content text-center">
      <h2>About us and how we can help you</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
      <a href="narrow-down-candidates.html" class="btn-banner-design">Get Started</a>
     </div>
  </div>
 </section>
 <section class="why-choose-us-sec">
  <div class="container">
    <div class="row align-items-center">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
       <div class="why-choose-img">
        <img src="{{ asset('assets/images/why-choose.png') }}">
       </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    <div class="heading-paragraph-design m-text-center">
      <h2>Why choose us</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
      <a href="lawyer-service-providing.html" class="btn-design-four">Our Services</a>
    </div>
    </div>
    </div>
    </div>
  </div>
 </section>
 <section class="about-contact-sec">
  <div class="container-1000px">
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="heading-paragraph-design m-text-center">
          <h2>Lorem ipsum lorem</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
          <a href="#" class="btn-design-four">Contact Us</a>
        </div>
        </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
       <div class="why-choose-img text-center half-mobile-img">
        <img src="{{ asset('assets/images/about-phone.png') }}">
       </div>
    </div>
    </div>
    </div>
  </div>
 </section>
 <section class="rating-section position-relative about-page-rating">
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
@endsection