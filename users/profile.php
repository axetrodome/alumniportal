<?php 
require_once '../core/init.php';
$store = new Store();
$user = new User();
if(!$username = Input::get('user')) :
	Redirect::to('../views/index.php');
elseif ($user->data()->groups != 2):
	Redirect::to('../views/index.php');
else :
	$user->get(array('username','=',$username));
	foreach($user->results() as $data){
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
			<li><a href="../admin/dashboard" class="nav-link">Dashboard</a></li>
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
				<a href="../users/profile?user=<?= escape($user->data()->username); ?>" class="nav-link active"><?= escape($store->setName($user->data()->username)); ?></a>
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
	<div style="min-height:500px;padding-top:70px">
		<div class="details-header">
			<h1><i class="fa fa-user"></i> Account details</h1>
		</div>
		<div class="details-container">
			<p> <i class="fa fa-user"></i> <?= escape($store->setName($data->first_name));?> <?= escape($store->setName($data->middle_name));?>. <?= escape($store->setName($data->last_name));?> </p>
			<p> <i class="fa fa-envelope"> Email: </i> <?= escape($data->email); ?></p>
			<p> <i class="fa fa-map-marker"> Location: </i> <?= escape($store->setName($data->address));?></p>
			<p> <i class="fa fa-wheelchair-alt"></i> Age: <?= date_diff(date_create($data->birthday),date_create('today'))->y ?></p>
			<p> <i class="fa fa-birthday-cake"> Birthday: </i> <?= $data->birthday; ?></p>
			<p> <i class="fa fa-random"></i> Gender: <?= escape($store->setName($data->gender)); ?></p>
			<p> <i class="fa fa-mobile"> Cellphone: </i> <?= escape($store->setName($data->cellphone));?></p>
			<p> <i class="fa fa-phone"></i> Telephone: <?= escape($store->setName($data->telephone)); ?></p>
			<p> <i class="fa fa-flag"> Nationality: </i> <?= escape($store->setName($data->nationality));?></p>
			<p> <i class="fa fa-building"> Company: </i> <?= escape($store->setName($data->company)); ?> </p>
			<p> <i class="fa fa-graduation-cap"> Year Graduated: </i> <?= escape($store->setName($data->year_graduated)); ?> </p>
		</div>
	</div>
</body>
<?php require_once '../functions/footer.php';  ?>
</html>
	<?php }
	endif; 
	?>
