<?php 
require_once '../core/init.php';
$user = new User();
$store = new Store();
$date = new DateTime('today');
$y = 1;
if($user->hasPermission('admin')){
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../functions/header.php'; ?>
	<link rel="stylesheet" href="../layouts/bootstrap/css/bootstrap.min.css">
	<script src="../layouts/bootstrap/js/bootstrap.min.js"></script>
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
			<h3>Users</h3>
				<p class="success">
					<?php 
						if(Session::exists('accepted')){
							?>
							<script>
								swal({
								  title: "Success!",
								  text: "<?= Session::flash('accepted'); ?>",
								  icon: "success",
								});
							</script>
							<?php
						}
					?>
				</p>
				<form method="POST" action="">
					<div class="form-group">
						<div class="input-group col-md-5">
							<div class="input-group-addon"><b class="fa fa-search"></b></div>
							<input type="text" name="searchUser" id="search" placeholder="Search.." class="form-control">
							<input type="hidden" name="token" value="<?= Token::generate(); ?>">
						<button type="submit" class="btn btn-small btn-success" name="searchbtn"><i class="fa fa-search"></i> Search</button>
						</div>
					</div>
				</form>
				<div class="table-responsive">	
					<table class="table">
						<thead class="thead-inverse">
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Age</th>
								<th style="width:13%">Date Joined</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						<?php
							$db = new PDO('mysql:host=localhost;dbname=alumniportal','root','');
							if(isset($_POST['searchbtn'])){
								$search = $_POST['searchUser'];
								$sql = "SELECT * FROM users WHERE joined LIKE '%$search%' OR username LIKE '%$search%' OR first_name LIKE '%$search%' OR middle_name LIKE '%$search%' OR last_name LIKE '%$search%' OR address LIKE '%$search%' OR course LIKE '%$search%' OR nationality LIKE '%$search%'";
								$stmt = $db->prepare($sql);
								$stmt->execute();
								$rows = $stmt->fetchAll(PDO::FETCH_OBJ);
								if ($stmt->rowCount() > 0){
									foreach($rows as $users){
								?>
						<tbody>
							<tr id="search">
								<td><?= $y; ?></td>
								<td><a href="../users/profile?user=<?= escape($users->username); ?>" class="nav-link"><?= $users->first_name ?> <?= $users->middle_name ?> <?= $users->last_name ?></a></td>
								<td><?= $users->email ?></td>
								<td><?= date_diff(date_create($users->birthday), date_create('today'))->y; ?></td>
								<td><?= $users->joined ?></td>
								<?php if($users->status == 0): ?>
								<td>
									<form action="accept.php" method="POST">
										<input type="hidden" name="user_id" value="<?= $users->id ?>" id="user_id">
										<input type="hidden" name="token" value="<?= Token::generate(); ?>">
										<button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Accept</button>
									</form>
								</td>
								<td>
									<form action="delete.php" method="POST" onsubmit="return confirm('Do you really want to delete the user?');">
										<input type="hidden" name="user_id" value="<?= $users->id ?>">
										<input type="hidden" name="token" value="<?= Token::generate(); ?>">
										<button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</button>
									</form>
								</td>
								<?php endif; ?>
							</tr>
						</tbody>
						<?php $y++; ?>
							<?php
									}

								}else{ ?>
								<div class="container">
									<h1>No users found try to search again.</h1>
								</div>
							<?php }

							}

						?>
					</table>
				</div>
			</div>
	<script src="../layouts/js/main.js"></script>
</body>
</html>
<?php 
	}else{
		Redirect::to('../views/index.php');
	}
?>
