<?php
require_once '../core/init.php';
$user = new User();
$post = new Post();
$store = new Store();
$db = DB::getInstance();
$news = true;
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
<body>
		<?php require_once '../functions/navigationbar.php';  ?>
		<div class="clearfix"></div>
		<div class="container margin">
			<div class="header-container">
				<span>lastest posts</span>
			</div>
			<?php
			//select all posts
			$page = !empty(Input::get('page')) ? (int)Input::get('page') : 1;
			$perPage = !empty(Input::get('per-page')) && Input::get('per-page') <= 50 ? (int)Input::get('per-page') : 5;
			// numbering
			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
			//get the content and pages
			$total = $post->total();
			$pages = ceil($total/$perPage);
			$post->limit(array('type','=','news'),5);
			foreach ($post->results() as $getpost):
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