<!doctype html>
<html lang="en">

<head>
  <title>User Login - Prickly Pear</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/font.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/slick-theme.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  @livewireStyles
  @yield('style')
</head>

<body>

  @include('layouts.includes.header')

  @include('layouts.includes.alerts')
  <!-- @if(Session::has('success'))
  <p class="alert alert-info">{{ Session::get('success') }}</p>
  @endif -->
  
  <main id="main-content">
    @yield('content')
  </main>

  @include('layouts.includes.footer')

  <script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script src="{{ asset('assets/js/slick.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <x-livewire-alert::scripts />

  @livewireScripts
  @yield('script')
  @stack('scripts')

</body>

</html>