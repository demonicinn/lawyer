<div class="lawyer-tabs_lists">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link{{ request()->routeIs('consultations.upcoming') ? ' active' : '' }}" href="{{ route('consultations.upcoming') }}">Upcoming</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ request()->routeIs('consultations.complete') ? ' active' : '' }}" href="{{route('consultations.complete')}}">Complete</a>
        </li>
        <li class="nav-item">
            <a class="nav-link{{ request()->routeIs('consultations.accepted') ? ' active' : '' }}" href="{{route('consultations.accepted')}}">Accepted</a>
        </li>
    </ul>
</div>