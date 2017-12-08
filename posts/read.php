<?php
require_once '../core/init.php';
$post = new Post();
$user = new User();
$store = new Store();
$url =  "{$_SERVER['REQUEST_URI']}";
$db = DB::getInstance();
$comment = new Comment();
$id = Input::get('comment_id');
if(isset($_POST['accept'])){
	$db = new PDO('mysql:host=localhost;dbname=alumniportal','root','');
	try{
		$db->query("UPDATE comments SET is_approved = 1 WHERE id = {$id}");
	}catch(Exception $e){
		die($e->getMessage());
	}
}
$validate = new Validation();
if(!$id = Input::get('post')){
	Redirect::to('..views/index.php');
}else{
		//check if POST and GET is not empty
	if(isset($_POST['comment-btn'])){
		if(Input::exists()){
			if(Token::check(Input::get('token'))){
				$validation = $validate->check($_POST,array(
					'comment' => array(
						'required' => true
					)
					));
					if($validation->passed()){
						try{
							$comment->create(
								array(
									'user_id' => Input::get('user_id'),
									'post_id' => Input::get('post_id'),
									'comment' => Input::get('comment'),
									'is_approved' => 0,
									'url' => Input::get('url'),
									'time_elapsed' => time()
								)
							);
						}catch(Exception $e){
							die($e->getMessage());
						}
					}else{
						foreach ($validation->errors() as $error) {
							echo $error,'<br>';
						}
					}
				}
			}
	}
	?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<nav class="nav">
		<ul>
			<li><a href="#" style="height:69px">
				<img src="../layouts/images/st-cath.png" class="nav-link img-logo"></a>
			</li>
			<li><a href="../views/index" class="nav-link">Home</a></li>
		<?php if($user->isLoggedin()): ?>
			<?php if($user->hasPermission('admin')) : ?>
			<li><a href="../admin/dashboard" class="nav-link">Dashboard</a></li>
			<?php endif; ?>
		<?php endif; ?>
			<li>
				<a href="#" class="nav-link active">Announcements</a>
				<ul>
					<li><a href="../views/news" class="sub-link">News</a></li>
					<li><a href="../views/news" class="sub-link">Events</a></li>
				</ul>
			</li>
			<?php if($user->isLoggedin()): ?>
			<li>
				<a href="../users/profile?user=<?= escape($user->data()->username); ?>" class="nav-link"><?= escape($store->setName($user->data()->username)); ?></a>
				<ul>
					<li><a href="../users/update" class="sub-link">Update details</a></li>
					<li><a href="../users/changepassword" class="sub-link">Change password</a></li>
					<li><a href="../users/logout" class="sub-link">Log out</a></li>
				</ul>
			</li>
			<?php endif; ?>
			<?php if(!$user->isLoggedin()): ?>
				<li>
					<a href="#" class="nav-link">Login/Register</a>
					<ul>
						<li><a href="../users/login" class="sub-link">Login</a></li>
						<li><a href="../users/register" class="sub-link">Register</a></li>
					</ul>
				</li>
			<?php endif; ?>
			<li><a href="../forums/section" class="nav-link">forum</a></li>
			<li>
				<form action="../posts/search" method="POST">
					<input type="text" name="search" placeholder="SEARCH" class="search">
					<span class="focus-border"></span>
					<button type="submit" class="search-btn" name="submit"><i class="fa fa-search"></i></button>
				</form>
			</li>
		</ul>
	</nav>	
<?php $post->selectAll('posts',array('id','=',$id)); ?>
<?php foreach($post->results() as $get){ ?>
<div style="min-height:500px;padding-top:100px;padding-left:50px;">
	<div class="full-content">
		<span class="type"><?= $get->type; ?></span>
		<div class="post-header">
			<h1><?php echo $get->title; ?></h1>
			<small class="simple-small">Posted: <?= $get->posted; ?></small><br>
			<small class="simple-small"><i class="fa fa-clock-o"></i> <?php echo $store->time_elapsed($get->time_elapsed); ?></small>
		</div>
		<p><?php echo $get->content; ?></p>
	</div>
	<h3>Comments</h3>
	<!-- get the comment for the post -->
	<?php $comment->get(array('post_id','=',$id)); ?>
	<?php foreach ($comment->results() as $comments ): ?>
		<?php if($comments->is_approved == 1): ?>
			<?php $time_elapsed = $store->time_elapsed($comments->time_elapsed); ?>
			<!-- get user who commented on the post -->
				<?php $user->get(array('id','=',$comments->user_id)); ?>
				<?php foreach($user->results() as $users ): ?>
						<div class="comments">
							<p><strong><?= $users->username; ?>:</strong><?= $comments->comment; ?></p>
							<small class="simple-small"><?= $time_elapsed; ?></small>
						</div>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php if(!$user->isLoggedin()):?>
			You need to <a href="../users/login.php">Login</a> or <a href="../users/register.php">Register</a> to post a comment <br>
		<?php elseif($user->hasPermission('admin')): ?>
				<?php $comment->get(array('post_id','=',$id)); ?>
				<?php foreach ($comment->results() as $comments ): ?>
					<?php if($comments->is_approved == 0): ?>
						<small class="simple-small">
							<h3>Pending comments.</h3>
						</small>
						<?php $time_elapsed = $store->time_elapsed($comments->time_elapsed); ?>
						<!-- get user who commented on the post -->
							<?php $user->get(array('id','=',$comments->user_id)); ?>
							<?php foreach($user->results() as $users ): ?>
									<div class="comments">
										<p><strong><?= $users->username; ?>:</strong><?= $comments->comment; ?></p>
										<small class="simple-small"><?= $time_elapsed; ?></small>
										<?php if($user->hasPermission('admin')) : ?>
											<form method="post">
												<input type="hidden" name="comment_id" value="<?= $comments->id; ?>">
												<input type="hidden" name="token" value="<?= Token::generate(); ?>">
												<button class="btn-submit" type="submit" name="accept"><i class="fa fa-check"></i>Approve</button>	
											</form>
										<?php endif; ?>
									</div>
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<div class="divider"></div>
					<h1>Leave a comment</h1>
					<div class="divider"></div>
					<form method="post">
							<div class="field">
								<textarea type="text" name="comment" placeholder="Comment" id="comment" class="comment"></textarea>
							</div>
							<input type="hidden" name="post_id" value="<?php echo $id; ?>">
							<input type="hidden" name="url" value="<?php echo $url; ?>">
							<input type="hidden" name="user_id" value="<?php echo $user->data()->id; ?>">
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
							<button type="submit" class="btn-submit" name="comment-btn">Comment</button>
					</form>
			<?php else: ?>
				<?php $comment->get(array('user_id','=',$user->data()->id)); ?>
				<?php if($comment->results() < 0):?>
					<small class="simple-small">
						<h3>Your comment is awaiting moderation.</h3>
					</small>
				<?php endif; ?>
				<?php foreach($comment->results() as $pending): ?>
					<?php $user->get(array('id','=',$user->data()->id)); ?>
						<?php foreach($user->results() as $users) : ?>
							<!-- check if post id is matched to the id of the selected post -->
							<?php if($id === $pending->post_id): ?>
								<?php if($pending->is_approved == 0): ?>
									<div class="comments">
										<p><i><b><?= $users->username ?>: </b><?= $pending->comment; ?></i></p>
										<small><i><?= $store->time_elapsed($pending->time_elapsed); ?></i></small>
									</div>
								<?php endif; ?>
							<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
	<div class="divider"></div>
	<h1>Leave a comment</h1>
	<div class="divider"></div>
	<form method="post">
			<div class="field">
				<textarea type="text" name="comment" placeholder="Comment" id="comment" class="comment"></textarea>
			</div>
			<input type="hidden" name="url" value="<?php echo $url; ?>">
			<input type="hidden" name="post_id" value="<?php echo $id; ?>">
			<input type="hidden" name="user_id" value="<?php echo $user->data()->id; ?>">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<button type="submit" class="btn-submit" name="comment-btn">Comment</button>
	</form>
	<?php endif; ?>
</div>
<?php require_once '../functions/footer.php' ?>
<script src="../layouts/js/main.js"></script>
</body>
</html>
<?php		
	}		
}
?>


