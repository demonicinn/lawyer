@extends('layouts.app')
@section('content')
	
	<input type="hidden" id="meeting_number" value="{{ @$booking->zoom_id }}">
	<input type="hidden" id="meeting_pwd" value="{{ @$booking->zoom_password }}">
	<input type="hidden" id="display_name" value="{{ $user->name }}">
	<input type="hidden" id="meeting_email" value="{{ $user->email }}">
	<input type="hidden" id="meeting_role" value="{{ $user->role=='lawyer' ? 1 : 0 }}">
	<input type="hidden" id="meeting_lang" value="en-US">
	<input type="hidden" id="meeting_china" value="0">

@endsection

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

<script>
    window.addEventListener('DOMContentLoaded', function(event) {
	  //console.log('DOM fully loaded and parsed');
	  websdkready();
	});

	var SDK_KEY = "aQGxehQBJFFVeVORcrZ7GApWitGIPP8GHSpu";
	var SDK_SECRET = "g3ZO0EmtO0rpFzEPMFGGTehNY0XL5IykgFmS";

	function websdkready() {

		var testTool = window.testTool;
		if (testTool.isMobileDevice()) {
			vConsole = new VConsole();
		}

		var meetingConfig = testTool.getMeetingConfig();

		meetingConfig.leaveUrl = "{{ route('zoom.leave', $booking->zoom_id) }}";

		ZoomMtg.preLoadWasm();
	  
		var signature = ZoomMtg.generateSDKSignature({
			meetingNumber: meetingConfig.mn,
			sdkKey: SDK_KEY,
			sdkSecret: SDK_SECRET,
			role: meetingConfig.role,
			success: function (res) {
				//console.log(res.result);
				
				meetingConfig.signature = res.result;
				meetingConfig.sdkKey = SDK_KEY;

				var joinUrl = "{{ route('zoom.meet') }}?" + testTool.serialize(meetingConfig);
				//console.log(joinUrl);
				window.open(joinUrl);
			},
		});


	}

</script>

@endsection