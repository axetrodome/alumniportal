<?php 
require_once '../core/init.php';
$user = new User();
$post = new Post();
$store = new Store();
$comment = new Comment();
$forum = new Forum();
$dashboard = true;
if(!$user->hasPermission('admin')){
	Redirect::to('../views/index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validation();
		$validation = $validate->check($_POST,array(
			'content' => array(
				'required' => true
			),
			'title' => array(
				'required' => true
			)
		));
		if($validation->passed()){
			$imgFile = $_FILES['image']['name'];
			$tmp_dir = $_FILES['image']['tmp_name'];
			$imgSize = $_FILES['image']['size'];
			$upload_dir = '../images/';
			// checking image extension
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
			//valid extensions
			$valid_extension = array('jpg','jpeg','png','gif');
			//name of image
			$image = rand(1000,1000000).".".$imgExt; //123123123.jpg
			if(in_array($imgExt, $valid_extension)){
				if($imgSize < 5000000){
					move_uploaded_file($tmp_dir, $upload_dir.$image);
				}
			}
			try{
				$post->create(
					array(
						'title' => Input::get('title'),
						'content' => Input::get('content'),
						'type' => Input::get('type'),
						'posted'=> date('Y-m-d'),
						'image' => $image,
						'time_elapsed' => time()
					)
				);
				Session::flash('success','Data added successfuly');
				Redirect::to('dashboard.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error,'</br>';
			}
		}
	}
}
if($user->isLoggedin()): ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php 
		if(Session::exists('success')){
			?>
			<script>
				swal({
				  title: "Success!",
				  text: "<?= Session::flash('success','Post has been added!'); ?>",
				  icon: "success",
				});
			</script>
			<?php
		}
	?>
	<?php require_once '../functions/navigationbar.php'; ?>
	<div class="divider"></div>
	<div class="divider"></div>
	<div class="divider"></div>
	<div class="divider"></div>
	<div class="divider"></div>
	<div class="container">
		<div class="dashboard">
			<div class="dashboard-header">
				<h3><i class="fa fa-bar-chart"></i>Statistics</h3>
			</div>
			<div class="dashboard-container">
				<div class="posts">
					<a href="../admin/posts">
						<h1><i class="fa fa-clipboard"></i></h1>
						<?php $post->page('posts',null); ?>
						<h3>Posts total:<?= $post->total(); ?></h3>
					</a>
				</div>
				<div class="users">
					<a href="../admin/users">
						<h1><i class="fa fa-user-o"></i></h1>
						<?php $user->page('users',null); ?>
						<h3>Users total:<?= $user->total(); ?></h3>
					</a>
				</div>
				<div class="commentss">
					<h1><i class="fa fa-comment-o"></i></h1>
					<?php $comment->page('comments',null); ?>
					<h3>Comments total:<?= $comment->total(); ?></h3>
				</div>
				<div class="forums">
					<a href="../forums/section">
						<h1><i class="fa fa-question-circle-o"></i></h1>
						<?php $forum->page('questions',null); ?>
						<h3>Forum Questions total:<?= $forum->total(); ?></h3>
					</a>
				</div>
			</div>
		</div>
	<!-- add javascript that will reset php form -->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="field">
			<div class="divider"></div>
			<small class="simple-small">Insert display image</small>
			<div class="divider"></div>
			<input type="file" name="image" accept="image/*">
		</div>
		<div class="col-3 input-effect">
			<input type="text" name="title" id="title" class="input effect-17" value="<?= escape(Input::get('title')); ?>">
			<label for="title" class="label" ><b>Title</b></label>
			<span class="focus"></span>
		</div>
		<div class="field">
			<textarea type="text" name="content" class="ckeditor" id="content"><?= Input::get('content'); ?></textarea>
		</div>
		<div class="divider"></div>
		<small class="simple-small">Select type</small>
		<div class="divider"></div>
		<select name="type" class="select">
			<option value="news">News</option>
			<option value="events">Events</option>
		</select>
		<input type="hidden" name="token" value="<?= Token::generate(); ?>">
		<div class="divider"></div>
		<a href="../views/index.php" class="btn-cancel">Cancel</a>
		<button type="submit" class="btn-submit">Add</button>
		<div class="divider"></div>
	</form>
	<!-- <?php if($user->hasPermission('admin')): ?> -->
<!-- 		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
		<!-- <div style="width:30%"> -->
<!-- 		 <nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		   <div class="navbar-header">
		   	<a href="#" class="navbar-brand">Pending Comments</a>
		   </div>
		   <ul class="navs navbar-nav col-md-5" style="padding-top:15px;">
		    <li class="dropdown">
		     <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span><span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
		     <ul class="dropdown-menu"></ul>
		    </li>
		   </ul>
		  </div>
		 </nav> -->
	<!-- <?php endif; ?> -->
<script src="../layouts/js/main.js"></script>
</body>
</html>
<?php else: ?>
	<?php Redirect::to('../views/index.php'); ?>
<?php endif; ?>