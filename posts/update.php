<?php
require_once '../core/init.php';
$url =  "{$_SERVER['REQUEST_URI']}";
//if not equal to $_GET['post'] redirect to index.php
if(!$id = Input::get('post')){
	Redirect::to('../views/index');
}else{
	$post = new Post();
	$user = new User();
	$store = new Store();
	//if not loggedin and no permission as admin redirect to index.php
	if(!$user->isLoggedin() || !$user->hasPermission('admin')){
		Redirect::to('../views/index.php');
	}else{
		//check if post id exists
		$post->selectAll('posts',array('id','=',$id));
		if(!$post->exists()){
			Redirect::to(404);
		}else{
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
						   
						foreach ($post->results() as $result){
							if($imgFile){
							 	$upload_dir = '../images/'; // upload directory 
							 	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
							 	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
								 $image = rand(1000,1000000).".".$imgExt;
								if(in_array($imgExt, $valid_extensions)){   
									if($imgSize < 5000000){
									   unlink($upload_dir.DIRECTORY_SEPARATOR.$result->image); //delete image in folder
									   move_uploaded_file($tmp_dir,$upload_dir.$image);
								  		}
								  	}
								}else{
								$image = $result->image;
							   }
						  }
						try{
							$post->update(array(
								'content' => Input::get('content'),
								'title' => Input::get('title'),
								'type' => Input::get('type'),
								'image' => $image,
								'status' => Input::get('status')
								// 'time_elapsed' => time()
								),$id);
							Session::flash('updated','Data updated successfuly');
							Redirect::to("{$url}");
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
	<?php 
		if(Session::exists('updated')){
			?>
			<script>
				swal({
				  title: "Success!",
				  text: "<?= Session::flash('updated','your details has been updated!'); ?>",
				  icon: "success",
				});
			</script>
			<?php
		}
	?>
<?php
foreach ($post->results() as $get) {
?>
	<nav class="nav">
		<ul>
			<li><a href="#" style="height:69px">
				<img src="../layouts/images/st-cath.png" class="nav-link img-logo"></a>
			</li>
			<li><a href="../views/index" class="nav-link">Home</a></li>
		<?php if($user->isLoggedin()): ?>
			<?php if($user->hasPermission('admin')) : ?>
			<li><a href="../admin/dashboard" class="nav-link active">Dashboard</a></li>
			<?php endif; ?>
		<?php endif; ?>
			<li>
				<a href="#" class="nav-link">Announcements</a>
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
					<a href="#" class="nav-link active">Login/Register</a>
					<ul>
						<li><a href="../users/login" class="sub-link active-sublink">Login</a></li>
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
	<div class="heigth"></div>
	<div class="container">
		<h3>Edit</h3>
		<form action="" method="post" enctype="multipart/form-data">
			<small class="simple-small">Edit display image</small>
			<div class="divider"></div>
			<div class="image-field">
				<img src="../images/<?= $get->image ?>">
				<div class="divider"></div>
				<input type="file" name="image" accept="image/*">
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="title" id="title" class="input effect-17" value="<?= $get->title; ?>">
				<label for="title" class="label" style="z-index:-2"><b>Title</b></label>
				<span class="focus"></span>
			</div>
			<div class="field">
				<textarea type="text" name="content" id="content" class="ckeditor" value=""><?= $get->content; ?></textarea><br>
			</div>
			<div class="divider"></div>
			<small class="simple-small">Select type</small>
			<div class="divider"></div>
			<select name="type" class="select">
				<option value="news"
				<?php 
					if($get->type == 'news'){
						echo 'selected';
					}
				?>
				>News</option>
				<option value="events"
				<?php 
					if($get->type == 'events'){
						echo 'selected';
					}
				?>
				>Events</option>
			</select>
			<div class="divider"></div>
			<small class="simple-small">Select Action</small>
			<div class="divider"></div>
			<select name="status" class="select">
				<option value=" "
				<?php 
					if($get->status == ''){
						echo 'selected';
					}
				?>
				>None</option>
				<option value="cancelled"
				<?php 
					if($get->status == 'cancelled'){
						echo 'selected';
					}
				?>	
				>Cancel</option>
				<option value="rescheduled"
				<?php 
					if($get->status == 'rescheduled'){
						echo 'selected';
					}
				?>
				>Reschedule</option>
			</select>
			<!-- always include token -->
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<div class="divider"></div>
			<a href="../views/index.php" class="btn-cancel">Cancel</a>
			<button type="submit" class="btn-submit">Add</button>
			<div class="divider"></div>
		</form>
	</div>
</body>
</html>
<?php
 } 
}
?>
<!-- $_SERVER['REQUEST_URI'] -->