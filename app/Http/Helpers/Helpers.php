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
	
	
	