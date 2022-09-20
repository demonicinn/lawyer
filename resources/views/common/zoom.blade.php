@extends('layouts.app')
@section('content')
	
	<input type="hidden" id="zoom_id" value="{{ @$booking->zoom_id }}">
	<input type="hidden" id="zoom_zak" value="{{ @$booking->zoom_zak }}">
	<input type="hidden" id="user_name" value="{{ $user->name }}">
	<input type="hidden" id="user_email" value="{{ $user->email }}">

	<div id="zoom_conference"></div>

@endsection

@section('script')
@viteReactRefresh
@vite('resources/js/app.jsx')
@endsection