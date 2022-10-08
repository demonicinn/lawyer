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
            <span class="user-span">login</span>
            <span class="user-icon"><img class="header-pic" src="{{ asset('assets/images/sample-img.png')}}"></span> 
          </button>
          <ul class="dropdown-menu p-3">
          <a class="dropdown-item btn_sign_up mb-3" href="{{ route('register') }}">Sign Up</a>
          <a class="dropdown-item btn_login" href="{{ route('login') }}">Login</a>
          </ul>
        </div>
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
            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">My profile</a></li>
            @elseif(Auth::user()->role=="lawyer")
            <li><a class="dropdown-item" href="{{ route($user->role) }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('lawyer.profile') }}">My profile</a></li>
            <li><a class="dropdown-item" href="{{ route('lawyer.leave') }}">Leave</a></li>
            @else
            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="{{ route('user.profile') }}">My profile</a></li>
            @endif
            @if (Auth::user()->role=="user" || Auth::user()->role=="lawyer")
            <li><a class="dropdown-item" href="{{ route('consultations.upcoming') }}">Consultations</a></li>
            @endif
            <li><a class="dropdown-item" href="{{route('change.password')}}">Change password</a></li>
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