<?php

	//check session route permissions accordingly user role
	function checkPermission($permissions){
		foreach ($permissions as $key => $value) {
			if($value == auth()->user()->role){
				return true;
			}
		}
		return false;
	}

	//pagination
	function pagi(){
		return 10;
	}
	
	function isEmail(){
		return true;
	}

	//get lat-long from zipcode
	function getLatLong($code){
		$mapsApiKey = config('services.google.api');
		$query = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($code)."&sensor=false&key=".$mapsApiKey;
		
		$result_string = file_get_contents($query);
		$result = json_decode($result_string, true);
		//dd($result);
		if(!empty($result['results'])){
			$lat = $result['results'][0]['geometry']['location']['lat'];
			$lng = $result['results'][0]['geometry']['location']['lng'];
			$address = $result['results'][0]['formatted_address'];
			return array('latitude'=>$lat,'longitude'=>$lng, 'address'=>$address);
		}
		 else {
			return false;
		}
	}



	
	
	