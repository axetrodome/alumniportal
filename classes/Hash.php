<?php
class Hash{
	public static function make($string,$salt = ''){
		//append $string to salt
		return hash('sha256',$string.$salt);
	}
	//generate random shits
	public static function salt($length){
		return mcrypt_create_iv($length);
	}
	public static function unique(){
		return self::make(uniqid());
	}
}

