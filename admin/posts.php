<?php 
require_once '../core/init.php';
$user = new User();
$store = new Store();
$post = new Post();

?>
<!DOCTYPE html>
<html>
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
			<li><a href="../admin/dashboard" class="nav-link active">Dashboard</a></li>
			<li>
				 <div class="dropdown">
				   <a href="#" onclick="myFunction()" class="dropbtn">Pending Comments <span class="label label-pill label-danger count" style="border-radius:10px;color:red;"></span></a>
				   <div id="myDropdown" class="dropdown-content">
				   		<a href="#" class="dropdown-menu"></a>
				   </div>
				 </div>
				</div>
			</li>
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
	<div style="height:70px;"></div>
	<div class="container">
		<h3>Posts</h3>
			<?php $post->selectAll('posts'); ?>
			<?php foreach($post->results() as $posts): ?>
				<b><?= $posts->title ?></b><i><?= $store->time_elapsed($posts->time_elapsed); ?> </i><a href="../posts/update.php?post=<?= escape($posts->id) ?>">Edit</a><br>
			<?php endforeach; ?>
	</div>
	</div>
<script src="../layouts/js/main.js"></script>
</body>
</html>