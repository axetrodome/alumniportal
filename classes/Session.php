<?php
class Session{
	public static function exists($name){
		return (isset($_SESSION[$name])) ? true : false;
	}
	public static function get($name){
		return $_SESSION[$name];
	}
	public static function put($name,$value){
		//echo session = Session::flash($name)
		return $_SESSION[$name] = $value;
	}
	public static function delete($name){
		if(self::exists($name)){
			unset($_SESSION[$name]);
		}
	}
	public static function flash($name,$string = ''){
		// if session already exists delete session
		if(self::exists($name)){
			$session = self::get($name);
			self::delete($name);
			return $session; 
		}else{
			//set string to $value and pass it in the session $name
			self::put($name,$string);
		}
	}
}