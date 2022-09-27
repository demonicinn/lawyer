import React, { useEffect } from 'react';
import { ZoomMtg } from '@zoomus/websdk';
import { KJUR } from 'jsrsasign';

const sdkKey = import.meta.env.VITE_ZOOM_SDK_KEY;
const sdkSecret = import.meta.env.VITE_ZOOM_SDK_SECRET;
const leaveUrlPath = import.meta.env.VITE_ZOOM_LEAVE_URL;


ZoomMtg.setZoomJSLib('https://source.zoom.us/2.7.0/lib', '/av');
ZoomMtg.preLoadWasm();
ZoomMtg.prepareWebSDK();
// loads language files, also passes any error messages to the ui
ZoomMtg.i18n.load('en-US');
ZoomMtg.i18n.reload('en-US');

const ZoomConfrence = () => {

	
	var meetingNumber = document.getElementById("zoom_id");
	if(meetingNumber){
		meetingNumber = meetingNumber.value;
	}

	var userName = document.getElementById("user_name");
	if(userName){
		userName = userName.value;
	}

	var userEmail = document.getElementById("user_email");
	if(userEmail){
		userEmail = userEmail.value;
	}

	var zak = document.getElementById("zoom_zak");
	if(zak){
		zak = zak.value;
	}
	
	let leaveUrl = leaveUrlPath + meetingNumber + '/leave';
	var passWord = '';
	var role = 0;

	//console.log('requirement', JSON.stringify(ZoomMtg.checkSystemRequirements()));
	

	function generateSignature(sdkKey, sdkSecret, meetingNumber, role) {
		return new Promise((res, rej) => {
			const iat = Math.round((new Date().getTime() - 30000) / 1000)
			const exp = iat + 60 * 60 * 2
			const oHeader = { alg: 'HS256', typ: 'JWT' }

			const oPayload = {
				sdkKey: sdkKey,
				mn: meetingNumber,
				role: role,
				iat: iat,
				exp: exp,
				appKey: sdkKey,
				tokenExp: iat + 60 * 60 * 2
			}

			const sHeader = JSON.stringify(oHeader)
			const sPayload = JSON.stringify(oPayload)
			const sdkJWT = KJUR.jws.JWS.sign('HS256', sHeader, sPayload, sdkSecret)
			
			res(sdkJWT);
		});
	}

	useEffect(() => {
		generateSignature(sdkKey, sdkSecret, meetingNumber, role).then((res) => {
			startMeeting(res);
		});
	}, [meetingNumber]);

	


	function startMeeting(signature){
		document.getElementById('zmmtg-root').style.display = 'block';

	    ZoomMtg.init({
	      leaveUrl: leaveUrl,
	      success: (success) => {
	        //console.log('called', success)

	        ZoomMtg.join({
	          signature: signature,
	          meetingNumber: meetingNumber,
	          userName: userName,
	          sdkKey: sdkKey,
	          userEmail: userEmail,
	          passWord: passWord,
	          zak: zak,
	          //tk: registrantToken,
	          success: (success) => {
	            //console.log('success', success)
	      			//leaveCurrentMeeting: leaveUrl,
	          },
	          error: (error) => {
	            console.log('error', error)
	            console.log(error)
	          }
	        })

	      },
	      error: (error) => {
	        console.log('error', error)
	        console.log(error)
	      }
	    })


	    ZoomMtg.inMeetingServiceListener('onUserLeave', function (data) {
    console.log('inMeetingServiceListener onUserLeave', data);
  });

	}


	return (
		<div className="App">
			<main>
				<h1>Zoom Meeting Started</h1>
			</main>
		</div>
	);
}


export default ZoomConfrence;