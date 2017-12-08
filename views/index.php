<?php
require_once '../core/init.php';
$user = new User();
$post = new Post();
$comment = new Comment();
$store = new Store();
$db = DB::getInstance();
//select all posts
$page = !empty(Input::get('page')) ? (int)Input::get('page') : 1;
$perPage = !empty(Input::get('per-page')) && Input::get('per-page') <= 50 ? (int)Input::get('per-page') : 10;
// numbering
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
// if(Session::exists('success')){
// 	echo Session::flash('success');
// }
$index = true;
?>
<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
	<?php require_once '../functions/header.php';  ?>
</head>
	<style>
	    /* jssor slider loading skin spin css */
	    .jssorl-009-spin img {
	        animation-name: jssorl-009-spin;
	        animation-duration: 1.6s;
	        animation-iteration-count: infinite;
	        animation-timing-function: linear;
	    }

	    @keyframes jssorl-009-spin {
	        from {
	            transform: rotate(0deg);
	        }

	        to {
	            transform: rotate(360deg);
	        }
	    }
	    .jssorb032 {position:absolute;}
	    .jssorb032 .i {position:absolute;cursor:pointer;}
	    .jssorb032 .i .b {fill:#fff;fill-opacity:0.7;stroke:#000;stroke-width:1200;stroke-miterlimit:10;stroke-opacity:0.25;}
	    .jssorb032 .i:hover .b {fill:#000;fill-opacity:.6;stroke:#fff;stroke-opacity:.35;}
	    .jssorb032 .iav .b {fill:#000;fill-opacity:1;stroke:#fff;stroke-opacity:.35;}
	    .jssorb032 .i.idn {opacity:.3;}

	    .jssora051 {display:block;position:absolute;cursor:pointer;}
	    .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
	    .jssora051:hover {opacity:.8;}
	    .jssora051.jssora051dn {opacity:.5;}
	    .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
/*	    .bg{
			background-attachment:fixed;
			background-position:0 150px 0 0;
			background-repeat:no-repeat;
			z-index:-1;
			opacity:.7;
			background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/9/92/Raffael_020.jpg/1200px-Raffael_020.jpg');
			width:100%;
			height:100%;
		}
		.caption{
			right:25px;
		}*/
	</style>
<body> 
	<?php require_once '../functions/navigationbar.php'; ?>
<!-- 	<div class="caption">
			<h1>Alumni Portal</h1>
			<img src="../layouts/images/logo.png">
		</div> 
		<div class="bg"></div> -->
		<?php if($page == 1): ?>	
			<?php include_once '../views/jquery.php'; ?>
			 <div class="announcement-container" id="events"> 
				 <h1>News and Events</h1> 
				 <?php $post->limit(array('type','=','events'),3); ?> 
				 <?php foreach($post->results() as $events): ?> 
					 <div class="event-container"> 
						 <div class="img-container"> 
							  <img src="../images/<?= $events->image ?>" > 
						 </div> 
						 <div class="title-container"> 
							  <h4><?php echo $events->title; ?></h4> 
						 </div>
						 <div class="divider"></div>
						 <div class="divider"></div>
						 <div class="link"> 
							 <a href="../posts/read?post=<?= escape($events->id); ?>">VIEW EVENT</a>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
			<div class="divider"></div>
		<?php endif; ?>
		<div class="clearfix"></div>
		<div class="front">
			<div>
				<div class="header-container">
					<span>lastest posts</span>
				</div>
				<?php
				//get the content and pages
				$post->page('posts',array($start,$perPage));
				$total = $post->total();
				$pages = ceil($total/$perPage);
				foreach ($post->results() as $getpost):
					$time_elapsed = $store->time_elapsed($getpost->time_elapsed);
					$content = $getpost->content; ?>
					<?php if($getpost->status != 'cancelled' && $getpost->status != 'rescheduled'): ?>
						<div class="post-container">
						<?php if($user->isLoggedin()): ?>
							<?php if($user->hasPermission('admin')): ?>
							<a href="../posts/update?post=<?= escape($getpost->id); ?>" class="edit-btn">Edit <i class="fa fa-pencil-square-o"></i></a>
							<?php endif; ?>	
						<?php endif; ?>
							<img src="../images/<?= $getpost->image ?>">
							<div class="post-content">
								<span class="type"><?= $getpost->type; ?></span>
								<h2><a href="../posts/read?post=<?= escape($getpost->id); ?>"><?= $getpost->title ?></a></h2>
								<?php if(strlen($content) > 300): ?>
								<p><?= $store->shortContent($content) ?><a href="../posts/read?post=<?= escape($getpost->id) ?>"> Read more..</a></p>
								<?php else: ?>
									<p><?php echo $content; ?></p>
									<p><a href="../posts/read?post=<?= escape($getpost->id); ?>">View</a></p>
								<?php endif; ?>
								<p class="time_elapsed"><small><i class="fa fa-clock-o"></i> <?= escape($time_elapsed); ?></small></p>
							</div>
						</div>
					<?php else: ?>
						<div class="divider"></div>
				<?php endif; ?>
			<?php endforeach; ?>	
			</div>
			<div>
				<?php if($page == 1): ?>
					<?php $post->limit(array('status','=','cancelled'),3); ?>
					<?php if($post->results() >	 0): ?>
						<div class="header-container">
							<span>Cancelled/Rescheduled events</span>
						</div>
						<div class="edited-posts">
							<?php foreach($post->results() as $events): ?>
								<?php if($user->isLoggedin()): ?>
									<?php if($user->hasPermission('admin')): ?>
									<a href="../posts/update?post=<?= escape($events->id); ?>" class="edit-btn">Edit <i class="fa fa-pencil-square-o"></i></a>
									<?php endif; ?>	
								<?php endif; ?>
								<img src="../images/<?= $events->image ?>" >
								<div class="edited-posts-content">
									<span class="type"><?= $events->type; ?></span>
									<h2><a href="../posts/read?post=<?= escape($events->id); ?>"><?= $events->title ?></a></h2>
									<?php if(strlen($events->content) > 300): ?>
									<?= $store->shortContent($events->content) ?><a href="../posts/read?post=<?= escape($events->id) ?>"> Read more..</a>
									<?php else: ?>
										<p><?php echo $events->content; ?></p>
										<p><a href="../posts/read?post=<?= escape($events->id); ?>">View</a></p>
									<?php endif; ?>
									<p class="time_elapsed"><small><i class="fa fa-clock-o"></i> <?= escape($store->time_elapsed($events->time_elapsed)); ?></small></p>
								</div>
							<?php endforeach; ?>
						</div>


						<?php $post->limit(array('status','=','rescheduled'),3); ?>
							<div class="edited-posts">
								<?php foreach($post->results() as $events): ?>
									<?php if($user->isLoggedin()): ?>
										<?php if($user->hasPermission('admin')): ?>
										<a href="../posts/update?post=<?= escape($events->id); ?>" class="edit-btn">Edit <i class="fa fa-pencil-square-o"></i></a>
										<?php endif; ?>	
									<?php endif; ?>
									<img src="../images/<?= $events->image ?>" >
									<div class="edited-posts-content">
										<span class="type"><?= $events->type; ?></span>
										<h2><a href="../posts/read?post=<?= escape($events->id); ?>"><?= $events->title ?></a></h2>
										<?php if(strlen($events->content) > 300): ?>
										<?= $store->shortContent($events->content) ?><a href="../posts/read?post=<?= escape($events->id) ?>"> Read more..</a>
										<?php else: ?>
											<p><?php echo $events->content; ?></p>
											<p><a href="../posts/read?post=<?= escape($events->id); ?>">View</a></p>
										<?php endif; ?>
										<p class="time_elapsed"><small><i class="fa fa-clock-o"></i> <?= escape($store->time_elapsed($events->time_elapsed)); ?></small></p>
									</div>
								<?php endforeach; ?>
							</div>
					<?php else: ?>

					<?php endif; ?>
				<?php endif; ?>
				<div class="frame">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCollegeofStCatherine&tabs=timeline&width=300&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="300" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>				
				</div>
			</div>
		</div>
		<div class="pagination">
	<!-- always start in 1 -->
			<?php for($x = 1;$x <= $pages; $x++): ?>
				<a href="?page=<?= $x; ?>&per-page=<?= $perPage ?>"<?php if($page === $x){echo "class='selected'";} ?>><?= $x; ?></a>
			<?php endfor; ?>
		</div>
		<?php require_once '../functions/footer.php'; ?>
<!--javascript scripts here -->
<script src="../layouts/js/jssor.slider-26.3.0.min.js" type="text/javascript"></script>
</body>
</html>
<!-- https://stackoverflow.com/questions/22588985/php-counting-mysql-rows-that-contain-the-same-value-in-one-column -->
