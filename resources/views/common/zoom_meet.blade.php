@extends('layouts.app')

@section('script')
<link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.7.0/css/bootstrap.css" />
<link type="text/css" rel="stylesheet" href="https://source.zoom.us/2.7.0/css/react-select.css" />

<script src="https://source.zoom.us/2.7.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/2.7.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/2.7.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/2.7.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/2.7.0/lib/vendor/lodash.min.js"></script>
<script src="https://source.zoom.us/zoom-meeting-2.7.0.min.js"></script>
<script src="{{ asset('meeting/tool.js') }}"></script>
<script src="{{ asset('meeting/vconsole.min.js') }}"></script>
<script src="{{ asset('meeting/meeting.js') }}"></script>
@endsection