
<?php
require_once '../core/init.php';
$user = new User();
$post = new Post();
$store = new Store();
$db = DB::getInstance();
?>
<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
	<title>Alumni Portal</title>
	<!-- css here -->
	<?php require_once '../functions/header.php';  ?>
</head>
<style type="text/css">
	
</style>
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
					<li><a href="../views/news" class="sub-link active-sublink">News</a></li>
					<li><a href="../views/events" class="sub-link">Events</a></li>
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
		<div class="clearfix"></div>
		<div class="container margin">
			<div class="header-container">
				<span>Results in "<?= Input::get('search'); ?>"</span>
			</div>
<?php
	if (isset($_POST["submit"])):
		$search = $_POST['search'];
		$db = new PDO('mysql:host=localhost;dbname=alumniportal','root','');
		$sql = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%' OR posted LIKE '%$search%' OR type LIKE '%$search%'";
		$stmt = $db->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
		$page = !empty(Input::get('page')) ? (int)Input::get('page') : 1;
		$perPage = !empty(Input::get('per-page')) && Input::get('per-page') <= 50 ? (int)Input::get('per-page') : 5;
		// numbering
		$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
		//get the content and pages
		$total = $post->total();
		$pages = ceil($total/$perPage);
		$post->limit(array('type','=','news'),5);
		if ($stmt->rowCount() > 0):
				foreach ($rows as $getpost):
					$time_elapsed = $store->time_elapsed($getpost->time_elapsed);
					$content = $getpost->content; ?>
					<div class="post-container">
					<?php if($user->isLoggedin()): ?>
						<?php if($user->hasPermission('admin')): ?>
						<a href="../posts/update.php?post=<?= escape($getpost->id); ?>" class="edit-btn">Edit <i class="fa fa-pencil-square-o"></i></a>
						<?php endif; ?>	
					<?php endif; ?>
						<img src="../images/<?= $getpost->image ?>">
						<div class="post-content">
							<span class="type"><?= $getpost->type; ?></span>
							<h2><a href="../posts/read.php?post=<?= escape($getpost->id); ?>"><?= $getpost->title ?></a></h2>
							<?php if(strlen($content) > 300): ?>
							<?= $store->shortContent($content) ?><a href="../posts/read.php?post=<?= escape($getpost->id) ?>"> Read more..</a>
							<?php else: ?>
								<p><?php echo $content; ?></p>
								<p><a href="../posts/read.php?post=<?= escape($getpost->id); ?>">View</a></p>
							<?php endif; ?>
							<p class="time_elapsed"><small><i class="fa fa-clock-o"></i> <?= escape($time_elapsed); ?></small></p>
						</div>
					</div>
			<?php endforeach; ?>
		<?php else : ?>
			<?php echo "There are no results."; ?>
			<h3>Search again</h3>
			<form action="../posts/search" method="POST">
				<input type="text" name="search" placeholder="SEARCH" class="search">
				<button type="submit" class="search-btn" name="submit"><i class="fa fa-search"></i></button>
			</form>
		<?php endif; ?>
	<?php else : ?>
		<?php echo "There are no results!"; ?>
			<h3>Search again</h3>
			<form action="../posts/search" method="POST">
				<input type="text" name="search" placeholder="SEARCH" class="search">
				<button type="submit" class="search-btn" name="submit"><i class="fa fa-search"></i></button>
			</form>
	<?php endif; ?>
		</div>
		<div class="pagination">
	<!-- always start in 1 -->
			<?php for($x = 1;$x <= $pages; $x++): ?>
				<a href="?page=<?= $x; ?>&per-page=<?= $perPage ?>"<?php if($page === $x){echo "class='selected'";} ?>><?= $x; ?></a>
			<?php endfor; ?>
		</div>
		<?php require_once '../functions/footer.php'; ?>
<!--javascript scripts here -->
<script type="text/javascript"></script>
</body>
</html>