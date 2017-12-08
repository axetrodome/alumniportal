<?php
require_once '../core/init.php';
$user = new User();
if(isset($_POST['user_id'])){
	$id = Input::get('user_id');
	try{
		$user->update(array(
			'status' => 1
			),$id);
		Session::flash('accepted','User is accepted!');
		Redirect::to('../admin/users');
	}catch(Exception $e){
		die($e->getMessage());
	}
}