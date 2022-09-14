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
        <div class="login_signup-btns">
          <a class="login-header-btn" href="{{ route('register') }}">Sign Up</a>
          <a class="login-header-btn" href="{{ route('login') }}">Login</a>
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
            @endif
         
            @if(Auth::user()->role=="admin")
            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">My profile</a></li>
            @elseif(Auth::user()->role=="lawyer")
            <li><a class="dropdown-item" href="{{ route('lawyer.profile') }}">My profile</a></li>
            @else
            <li><a class="dropdown-item" href="#">My profile</a></li>
            @endif

            @if(Auth::user()->role=="lawyer")
            <li><a class="dropdown-item" href="{{ route('lawyer.leave') }}">Leave</a></li>
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