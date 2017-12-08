<?php
class Redirect{
	public static function to($location = null){
		if($location){
			if(is_numeric($location)){
				switch ($location) {
					case 404:
					//display 404 to let the user he is in the 404 page
						header('HTTP/1.0 404 not found');
						include '../includes/errors/404.php';
						exit(); 
						break;
				}
			}
			header('Location:'.$location);
			exit();
			//exit(message) or exit the current script
		}
	}
}
