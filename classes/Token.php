<?php 
class Token{
	public static function generate(){
		// set session name to token
		return Session::put(Config::get('session/token_name'),md5(uniqid()));
	}
	//check if token exists;
	public static function check($token){
		$tokenName = Config::get('session/token_name');
		//if token is = to the set to token name delete it and set another
		if(Session::exists($tokenName) && $token === Session::get($tokenName)){
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
}