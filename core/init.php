<?php
ob_start();
session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => '127.0.0.1',
		'user' => 'root',
		'pass' => '',
		'db' => 'alumniportal'
		),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
		),
	'remember' => array(   
		'cookie_name' => 'hash',
		'cookie_expiry' => 84000
	)
);
spl_autoload_register(function($class){
	require_once '../classes/'.$class.'.php';
});
require_once '../functions/sanitize.php';
//remember me function
if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session',array('hash','=',$hash));
	if($hashCheck->count()){
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
