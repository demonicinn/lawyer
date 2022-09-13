@extends('layouts.app')
@section('content')
@livewire('schedule-consultation', ['lawyerID' => $lawyerID])
@endsection