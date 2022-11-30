<footer id="footer">
  <div class="footer-container">
    <div class="footer-row d-flex">
      <div class="footer-column footer-column-1">
        <div class="footer-widget footer-widget-first">
          <div class="footer-logo">
            <a href="/"><img src="{{ asset('assets/images/logo/footer_logo.png') }}"></a>
          </div>
          <!-- <h4 class="footer-heading">Follow Us</h4>
          <div class="footer-social-icons">
            <a href="#" class="twitter"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" class="facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" class="instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="linkedin"><i class="fa-brands fa-linkedin"></i></a>
          </div> -->
        </div>
      </div>
      <div class="footer-column footer-column-2">
        <div class="footer-widget footer-widget-second">
          <h4 class="footer-heading">Practice Areas</h4>
          <ul class="list-unstyled menu-footer-ul">
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=21&type=litigation" class="search-ho" data-search="21" data-type="litigation">Personal Injury – Plaintiff</a></li>
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=14&type=litigation" class="search-ho" data-search="14" data-type="litigation">Divorce/Family</a></li>
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=24&type=contract" class="search-ho" data-search="24" data-type="contract">Wills, Trusts, & Estates</a></li>
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=7&type=litigation" class="search-ho" data-search="7" data-type="litigation">Class Action/Mass Tort</a></li>
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=10&type=contract" class="search-ho" data-search="10" data-type="contract">Small Business Contracts</a></li>
            <li><a href="{{ route('lawyers.home') }}?litigations[0]=8&type=litigation" class="search-ho" data-search="8" data-type="litigation">Commercial Litigation</a></li>
            <li><a href="{{ route('narrow.down') }}" class="see-all">See All</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-column footer-column-3">
        <div class="footer-widget footer-widget-third">
          <h4 class="footer-heading">Resources</h4>
          <ul class="list-unstyled menu-footer-ul">
            
            <li><a href="">Articles</a></li>
            <li><a href="{{ route('faq') }}">FAQ</a></li>
            
            <li><a href="{{ auth()->check() ? route('support') : route('login', ['redirect'=>'true', 'goto'=>'support']) }}">Support</a></li>
            
            @if(auth()->check())
              @if(auth()->user()->role=='user')
                <li><a href="{{ route('user') }}">Client Portal</a></li>
              @endif

              @if(auth()->user()->role=='lawyer')
              <li><a href="{{ route('lawyer') }}">Lawyer Portal</a></li>
              @endif

              @if(auth()->user()->role=='admin')
              <li><a href="{{ route('admin') }}">Dashboard</a></li>
              @endif
            @else
              <li><a href="{{ route('user') }}">Client Portal</a></li>
              <li><a href="{{ route('register') }}">Lawyer Sign Up</a></li>
              <li><a href="{{ route('lawyer') }}">Lawyer Portal</a></li>
            @endif

          </ul>
        </div>
      </div>
      <div class="footer-column footer-column-4">
        <div class="footer-widget footer-widget-four">
          <h4 class="footer-heading">Company</h4>
          <ul class="list-unstyled menu-footer-ul">
          <li><a href="{{route('about')}}">About Us</a></li>
            <li><a href="{{route('joinTeam')}}">Join the Team</a></li>
            <li><a href="{{ route('privacyPolicy') }}">Privacy Policy</a></li>
            <li><a href="{{ route('termsService') }}">Terms of Service</a></li>         
          </ul>
        </div>
      </div>
    </div>
    <div class="copy-right text-center">
      <p>Copyright © 2022 Prickly Pear, all rights reserved.</p>
    </div>
  </div>
</footer>