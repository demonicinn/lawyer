import React, { useEffect } from 'react';
import { ZoomMtg } from '@zoomus/websdk';
import { KJUR } from 'jsrsasign';


const ZoomConfrence = () => {

	//var apiKey = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjY3Y0xDSXgwUnFhVk5uclBhSldoY3ciLCJleHAiOjE2NjMyNDExNjQsImlhdCI6MTY2MjYzNjM2M30.vph2Ald8HDA_KkjMbWFazUBi9hIsaasgis4PzVutFAg';
	var sdkKey = 'LLarU57l8YdjKk2aqgidlm7REbmlVcb8RHSy';
	var sdkSecret = 'QO9FC4KOBku8qNMHUFUyPsNANFVgITEC5jZG';
	
	var meetingNumber = '75742539373';
	var role = 0;

	var leaveUrl = 'http://localhost:8000';
	var userName = 'React';
	var userEmail = 'ram@yopmail.com';
	var passWord = 'JWi9XQ';
	//var passWord = 'bMvZbZv0ESbyZaDrzsbicpRcbR4vf2.1';
	//var registrantToken = '';

	ZoomMtg.preLoadWasm();
	ZoomMtg.prepareJssdk();
	ZoomMtg.setZoomJSLib('https://source.zoom.us/2.7.0/lib', '/av');
	

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


	generateSignature(sdkKey, sdkSecret, meetingNumber, role).then((res) => {
		startMeeting(res);
	});


	function startMeeting(signature){
		document.getElementById('zmmtg-root').style.display = 'block';

	    ZoomMtg.init({
	      leaveUrl: leaveUrl,
	      success: (success) => {
	        console.log('called', success)

	        ZoomMtg.join({
	          signature: signature,
	          meetingNumber: meetingNumber,
	          userName: userName,
	          sdkKey: sdkKey,
	          userEmail: userEmail,
	          passWord: passWord,
	          //tk: registrantToken,
	          success: (success) => {
	            console.log('success', success)
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