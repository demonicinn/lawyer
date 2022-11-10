@php

$user = auth()->user();

@endphp

<header id="header">
  <div class="container-1340px">
    <div class="header-wrapper">
      <div class="logo-left-column">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo/logo.png') }}"></a>
      </div>
      <div class="login-right-column">
        @guest
      
        <div class="login_signup-btns dropdown">
        <button type="button" class="dropdown-toggle login-header-btn" data-bs-toggle="dropdown">
            <span class="drop-icon"><i class="fa-solid fa-angle-down"></i></span>
            <span class="user-span">Menu </span>
            <!-- <span class="user-icon"><img class="header-pic" src="{{ asset('assets/images/sample-img.png')}}"></span>  -->
          </button>
          <ul class="dropdown-menu py-3">
            <a class="dropdown-item " href="{{ route('login') }}">Login</a>
          <a class="dropdown-item " href="{{ route('register') }}">Lawyer Sign Up</a>
          <a class="dropdown-item  mb-3" href="{{ route('narrow.down') }}" >Find a lawyer</a>
          </ul>
        </div>

       
        {{-- <a class="login-header-btn btn_sign_up mb-3 me-3 py-3" href="{{ route('register') }}">Sign Up</a>
          <a class="login-header-btn btn_login py-3" href="{{ route('login') }}">Login</a> --}}
        @else
        <div class="dropdown">
          <button type="button" class="dropdown-toggle login-header-btn" data-bs-toggle="dropdown">
            <span class="drop-icon"><i class="fa-solid fa-angle-down"></i></span>
            <span class="user-span">{{ $user->name }}</span>
            <span class="user-icon"><img class="header-pic" src="{{ $user->profile_pic}}"></span>
          </button>
          <ul class="dropdown-menu">
            @if(Auth::user()->role=="admin")
            <li><a class="dropdown-item" href="{{ route($user->role) }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.transactions') }}">Transactions</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.joinTeam') }}">Join the Team</a></li>
            @elseif(Auth::user()->role=="lawyer")
            <li><a class="dropdown-item" href="{{ route($user->role) }}">My Portal</a></li>
            <li><a class="dropdown-item" href="{{ route('lawyer.profile') }}">My Profile</a></li>

            
            {{--
            <li><a class="dropdown-item" href="{{ route('lawyer.leave') }}">Leave</a></li>
            --}}

            <li><a class="dropdown-item" href="{{ route('lawyer.subscription') }}">Subscription</a></li>
            <li><a class="dropdown-item" href="{{ route('lawyer.banking.success') }}">Bank Info</a></li>

            @else
            <li><a class="dropdown-item" href="{{ route('user') }}">My Portal</a></li>
            <li><a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a></li>

            <li><a class="dropdown-item" href="{{ route('user.saved.lawyer') }}">Saved Lawyers</a></li>
            <li><a class="dropdown-item" href="{{ route('consultations.upcoming') }}">Consultations</a></li>


            

            @endif
            <li><a class="dropdown-item" href="{{route('change.password')}}">Change Password</a></li>
            <li><a class="dropdown-item" href="{{route('support')}}">Support</a></li>
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>


          </ul>
        </div>
        @endguest

      </div>


    </div>
  </div>
</header>