@extends('layouts.app')
@section('content')
<section class="body-banner dashboard_profile-sec min-height-100vh">
    <div class="container">
        <div class="heading-paragraph-design text-center position-relative go-back-wrap mb-5">
            <h2>Dashboard</h2>
        </div>
        <div class="dashboard_wrapper">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <div class="data-content-box">
                            <h4>UPCOMING CONSULTATIONS</h4>
                            <h2 class="number-value">23</h2>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="options-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <div class="data-content-box">
                            <h4>COMPLETED CONSULTATIONS</h4>
                            <h2 class="number-value">198</h2>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="options-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <div class="data-content-box">
                            <h4>CURRENT <br>CASES</h4>
                            <h2 class="number-value">1,586</h2>
                        </div>
                        <div class="dropdown">
                            <button type="button" class="options-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.lawyers.index') }}">
                            <h4>LAWYERS <br>AVAILABLE</h4>
                            <h2 class="number-value">137</h2>
                        </a>
                        <div class="dropdown">
                            <button type="button" class="options-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Link 1</a></li>
                                <li><a class="dropdown-item" href="#">Link 2</a></li>
                                <li><a class="dropdown-item" href="#">Link 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.litigations.index') }}">
                            <h4>LITIGATIONS</h4>
                            <h2 class="number-value">23</h2>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.contracts.index') }}">
                            <h4>CONTRACTS</h4>
                            <h2 class="number-value">23</h2>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.states.index') }}">
                            <h4>STATES</h4>
                            <h2 class="number-value">23</h2>
                        </a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="data-white-box position-relative">
                        <a class="data-content-box" href="{{ route('admin.subscriptions.index') }}">
                            <h4>SUBSCRIPTIONS</h4>
                            <h2 class="number-value">23</h2>
                        </a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</section>
@endsection