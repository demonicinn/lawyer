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



	function getBookingsCount($month, $year){
		$user = auth()->user();

		$data = $user->booking()->whereYear('booking_date', $year)->whereMonth('booking_date', $month)->count();

		if(@$data){
			return $data;
		}
		else{
			return '0';
		}
	}
	
	
	function getZoomID($url){
		$uri_path = parse_url($url, PHP_URL_PATH);
        $uri_segments = explode('/', $uri_path);

    //dd($uri_segments);
        return $uri_segments[2];
	}
	
	
	function litigationsData($id){
		$data = \App\Models\Litigation::find($id);
	
		return @$data->name;
	}
	
	function contractsData($id){
		$data = \App\Models\Contract::find($id);
		
		return @$data->name;
	}


	function practiceArea($type, $id){

		$ids = json_decode($id);
		//$id = json_decode($id);
		if($type=='litigations'){
			$practices = \App\Models\Litigation::whereIn('id', $ids)->get();
		}
		else {
			$practices = \App\Models\Contract::whereIn('id', $ids)->get();
		}


		$data = '';

		foreach(@$practices as $practice){
            $data = $data ? $data.', '.$practice->name : $practice->name;
        }

        return $data;
	}


    function lawyerDescWithRating($users, $date3Months, $available2days){
        $newUserArray = array();
        
        $date = date('Y-m-d');
        $day = date('l');
    
        $date1 = \Carbon\Carbon::parse($date)->add(1, 'day')->format('Y-m-d');
        $day1 = \Carbon\Carbon::parse($date)->add(1, 'day')->format('l');
        
        $date7 = \Carbon\Carbon::parse($date)->add(6, 'day')->format('Y-m-d');
       
        
        $period = \Carbon\CarbonPeriod::create($date, $date7);
        
        //dd( $date7);
        
        
        foreach($users as $user){
            
            
            $totalCount = $user->lawyerReviews()->count();
            $totalRating = $user->lawyerReviews()->sum('rating');
            
            
            if($totalCount > 0){
                $overAllRating = $totalRating / $totalCount;
                
                
                $countCancleBookings = $user->booking()->where('is_canceled', '1')->where('booking_date', '>=', $date3Months)->count();
                
                $checkRating = 0;
                if($countCancleBookings > '0' && $countCancleBookings <= '2'){
                    $checkRating = 0.5;
                }
                if($countCancleBookings >= '3' && $countCancleBookings <= '9'){
                    $checkRating = 1;
                }
                if($countCancleBookings >= '10'){
                    $checkRating = 2;
                }
            
                $newRating = $overAllRating - $checkRating;
                //dd($newRating);
            
                $user->rating = number_format($newRating, 1);
            }
            else {
                $user->rating = 0;
				}
            
            
            $userData = [];
            $userData['id'] = $user->id;
            $userData['name'] = $user->name;
            $userData['email'] = $user->email;
            $userData['profile_pic'] = $user->profile_pic;
            $userData['contact_number'] = $user->contact_number;
            $userData['rating'] = $user->rating;
            $userData['details'] = $user->details;
            $userData['status'] = $user->status;
            
            
            
            //......
            $newRate = 7;
            
            foreach ($period as $pdate) {
                $dayp = $pdate->format('l');
                $ndate = $pdate->format('Y-m-d');
            
                //...
                foreach($user->lawyerHours as $hour){
                    if(@$hour->day){
                        $dayData = json_decode($hour->day);
                        if(in_array($dayp, $dayData)){
                            
                            $days = Carbon\Carbon::parse($date)->diffInDays(Carbon\Carbon::parse($ndate));
                            
                            if($days < $newRate){
                                $newRate = $days;
                            }
                            
                            
                        }
                    }
                }
                
            }
            
            $userData['position'] = $newRate;
            
            
            //...........
            if($available2days==true){
                foreach($user->lawyerHours as $hour){
                    
                    if(@$hour->date>=$date && $hour->date<=$date1){
                        array_push($newUserArray, $userData);
                    }
                        if(@$hour->day){
                            $dayData = json_decode($hour->day);
                            
                            ////dd($day1);
                            if(in_array($day, $dayData) || in_array($day1, $dayData)){
                                array_push($newUserArray, $userData);
                            }
                        }
                }
            }
            else {
                array_push($newUserArray, $userData);
            }
            
            
            
        }
        
        
        array_multisort(
            array_column($newUserArray, 'position'), SORT_ASC,
            array_column($newUserArray, 'rating'), SORT_DESC,
            $newUserArray);
        
        
        $tempArr = array_unique(array_column($newUserArray, 'id'));
        $datas = array_intersect_key($newUserArray, $tempArr);

        //dd($datas);
        return $datas;
    }

	
	
	function lawyerProfileUrl($user){
		$name = $user->first_name.'-'.$user->last_name;
		$name = strtolower($name);
		
		$profile_url = route('lawyer.url', [$name, $user->id]);
				
		return $profile_url;
	}