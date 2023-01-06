@extends('layouts.app')
@section('content')
<section class="content-heading_description-wrapper term-conditions-page">
<div class="container">
  <div class="content-heading_description">
    <h2>Your Custom Lawyer Profile Link</h2>
    <div class="download_links">
        <div class="favi_icon">
          <p><b>1.</b> Download the Prickly Pear icon by clicking the image below. </p>
          <a href="{{ asset('assets/favi_icon3.png') }}" class="favi_img" download >	<img src="{{ asset('assets/favi_icon3.png') }}" > </a>
        </div>
        
        <div class="profile_screenshot">
            <p><b>2.</b> Login to your lawyer account and copy the url from your profile. Use this link to connect it to the Prickly Pear icon on your website. It can also be used to share with your potential clients. </p>
            <img src="{{ asset('assets/images/profile3.png') }}">
        </div>
    </div>
 </div>
</div>
</section>
@endsection