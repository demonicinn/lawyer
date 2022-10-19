@extends('layouts.app')
@section('content')
<section class="about-banner-sec " style="background-image: url('{{ asset('assets/images/home-banner.png') }}');">
  <div class="container">
     <div class="homepbanner-content text-center">
      <h2>About us and how we can help you</h2>
      <p>At Prickly Pear, we know how difficult it can be to find a lawyer that fits your needs. We created our company to provide potential clients with the information and tools they need to make quality decisions about their legal representation, and we strive to make these decisions as simple and painless as possible. </p>
      <!-- <a href="narrow-down-candidates.html" class="btn-banner-design">Get Started</a> -->
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
      <p>Prickly Pear simplifies the process of finding a lawyer. You only see lawyers that practice the area of law you need, are seeking new clients, and have availability for a video consultation to address your concerns and answer your questions before moving forward. We make it as simple as possible to make a decision you’re happy with, and we are always looking for ways to be better. </p>
      <a href="lawyer-service-providing.html" class="btn-design-four">Find a Lawyer</a>
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
          <h2>What sets us apart</h2>
          <p>Unlike other legal directories, we provide advanced filters that help narrow down which lawyer is right for you. We also provide the opportunity to easily schedule a video consultation with the lawyer to determine if they are the right fit. Additionally, we won’t ask for your personal information until you schedule a consultation. </p>
          <a href="#" class="btn-design-four">See The Difference</a>
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
            <h2>Doing our best to provide five-star service</h2>
            <!-- <p>Lorem ipsum dolor sit amet. Et impedit similique et quibusdam quia est rerum eaque. Voluptatem eligendi est dicta adipisci sed voluptas deserunt.</p> -->
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