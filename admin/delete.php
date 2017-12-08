<?php
require_once '../core/init.php';
header('Content-type: application/json; charset=UTF-8');
$DBcon = new PDO('mysql:host=localhost;dbname=alumniportal','root','');
$response = array();
if ($_POST['user_id']) {
 	$id = Input::get('user_id');
    $query = "DELETE FROM users WHERE id= :id";
    $stmt = $DBcon->prepare( $query );
    $stmt->execute(array(':id'=>$id));
    if ($stmt) {
        $response['status']  = 'success';
        header("Location:users.php");
 $response['message'] = 'User Deleted Successfully ...';
    } else {
        $response['status']  = 'error';
 $response['message'] = 'Unable to delete product ...';
    }
}