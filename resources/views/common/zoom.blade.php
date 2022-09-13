@extends('layouts.app')
@section('content')

	<div id="zoom_conference"></div>

@endsection

@section('script')
@viteReactRefresh
@vite('resources/js/app.jsx')
@endsection