<?php 
require_once '../core/init.php';

$db = DB::getInstance();
$post = new Post();
$commnet = new Comment();
$user = new User();
// $user = $db->insert('users',array(
// 	'username' => 'axelmhar',
// 	'email' => 'working bruuuh@yahoo.com',
// 	'password' => 'axelchen',
// 	'username' => 'axetrodome',
// 	'groups' => 1
// 	));
// // $get = $db->get('users',array('groups','=',1));
// // foreach ($get->results() as $get) {
// // 	# code...
// // echo $get->username;
// // }
// $get = $db->get('posts',null);
// foreach ($get->results() as $get) {
// 	# code...
// 	echo $get->content;
// }
$comment->pending(array('user_id','=',15)); 
 foreach($comment->pendingresults() as $pending): 
	 if($pending->is_approved == 0): 
		<p><?= $pending->body; </p>
	 endif; 
 endforeach; 
