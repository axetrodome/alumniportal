<?php 
require_once '../core/init.php';

$db = DB::getInstance();
$post = new Post();
$comment = new Comment();
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
// $post->selectAll('posts',array('id','=',1));
// if($post->postResults() > 0){
// 	foreach ($post->postResults() as $get) {
// 		echo $get->content;
// 	}
// }else{
// 	echo 'not found bruh';
// }
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 5;
?>

<?php $comment->get(array('post_id','=',$id)); ?>
<?php foreach ($comment->results() as $comments ): ?>
	<?php if($comments->is_approved == 0): ?>
		<?php $time_elapsed = $store->time_elapsed($comments->time_elapsed); ?>
		<!-- get user who commented on the post -->
			<?php $user->get(array('id','=',$user->data()->id )); ?>
			<?php foreach($user->results() as $users ): ?>
					<div class="comments">
						<p><i><?= $users->username; ?>:<?= $comments->comment; ?></i></p>
					</div>
			<?php endforeach; ?>
		<?php else: ?>
			<!-- some content here -->
			<!-- its looping because it's inside the foreach -->
		<?php endif; ?>
	<?php endforeach; ?>
				<?php $comment->pending(array('user_id','=',$user->data()->id)); ?>
					<?php foreach($comment->pendingresults() as $pending): ?>
						<?php if($pending->is_approved == 0): ?>
							<p><?= $pending->body; ?></p>
						<?php endif; ?>
					<?php endforeach; ?>

<!-- <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FYOUR-FB-PAGE-ID&width=600&colorscheme=light&show_faces=true&border_color&stream=true&header=true&height=435"
scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:600px; height:430px; background: white; float:left; " allowTransparency="true">
</iframe> -->

