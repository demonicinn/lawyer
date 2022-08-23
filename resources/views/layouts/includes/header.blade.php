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
        <div class="dropdown">
          <a class="dropdown-toggle login-header-btn" href="{{ route('register') }}">Sign Up</a>
          <a class="dropdown-toggle login-header-btn" href="{{ route('login') }}">Login</a>
        </div>
        @else
        <div class="dropdown">
          <button type="button" class="dropdown-toggle login-header-btn" data-bs-toggle="dropdown">
            <span class="drop-icon"><i class="fa-solid fa-angle-down"></i></span>
            {{ $user->name }}
            <span class="user-icon"><i class="fa-solid fa-user"></i></span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route($user->role) }}">Dashboard</a></li>
            <li><a class="dropdown-item" href="#">My profile</a></li>
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