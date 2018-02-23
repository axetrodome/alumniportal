<?php 
$user = new User();
$partner = new Partner();
$store = new Store();
$db = DB::getInstance();
require_once '../admin/fetch.php';
?>
<nav class="nav">
	<ul>
		<li><a href="#" style="height:69px">
			<img src="../layouts/images/st-cath.png" class="nav-link img-logo"></a>
		</li>
		<li><a href="../views/index" class="nav-link <?php echo $index === true ? 'active' : '' ?>">Home</a></li>
	<?php if($user->isLoggedin()): ?>
		<?php if($user->hasPermission('admin')) : ?>
		<li><a href="../admin/dashboard" class="nav-link <?php echo $dashboard === true ? 'active' : '' ?>">Dashboard</a></li>
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
			<a href="#" class="nav-link <?php echo $news === true || $events === true ? 'active' : '' ?>">Announcements</a>
			<ul>
				<li><a href="../views/news" class="sub-link <?php echo $news === true ? 'active-sublink' : '' ?>">News</a></li>
				<li><a href="../views/events" class="sub-link <?php echo $events === true ? 'active-sublink' : '' ?>">Events</a></li>
			</ul>
		</li>
		<?php if($user->isLoggedin()): ?>
		<li>
			<a href="../users/profile?user=<?= escape($user->data()->username); ?>" class="nav-link <?php echo $update === true || $changepass === true ? 'active' : '' ?>"><?= escape($store->setName($user->data()->first_name)); ?></a>
			<ul>
				<li><a href="../users/update" class="sub-link <?php echo $update === true ? 'active-sublink' : '' ?>">Update details</a></li>
				<li><a href="../users/changepassword" class="sub-link <?php echo $changepass === true ? 'active-sublink' : '' ?>">Change password</a></li>
				<li><a href="../users/logout" class="sub-link">Log out</a></li>
			</ul>
		</li>
		<?php endif; ?>
		<?php if($partner->isLoggedin()): ?>
		<li>
			<a href="../jobs/profile?partner=<?= escape($partner->data()->company_name); ?>" class="nav-link <?php echo $update === true || $changepass === true ? 'active' : '' ?>"><?= escape($store->setName($partner->data()->company_name)); ?></a>
			<ul>
				<li><a href="../users/update" class="sub-link <?php echo $update === true ? 'active-sublink' : '' ?>">Update details</a></li>
				<li><a href="../users/changepassword" class="sub-link <?php echo $changepass === true ? 'active-sublink' : '' ?>">Change password</a></li>
				<li><a href="../users/logout" class="sub-link">Log out</a></li>
			</ul>
		</li>
		<?php endif; ?>
		<?php if(!$user->isLoggedin()): ?>
			<li>
				<a href="#" class="nav-link <?php echo $login === true || $register === true ? 'active' : '' ?>">Alumni</a>
				<ul>
					<li><a href="../users/login" class="sub-link <?php echo $login === true ? 'active-sublink' : '' ?>">Login</a></li>
					<li><a href="../users/register" class="sub-link <?php echo $register === true ? 'active-sublink' : '' ?>">Register</a></li>
				</ul>
			</li>
		<li>
			<a href="../jobs/partner.php" class="nav-link <?php echo $partner === true || $partners_login === true ? 'active' : '' ?>">Partner</a>
			<ul>
				<li><a href="../jobs/partner.php" class="sub-link <?php echo $partner === true ? 'active-sublink' : '' ?>">Register</a></li>
				<li><a href="../jobs/partners_login.php" class="sub-link <?php echo $partners_login === true ? 'active-sublink' : '' ?>">Login</a></li>
			</ul>
		</li>
		<?php endif; ?>
		<li><a href="../jobs/jobs.php" class="nav-link <?php echo $jobs === true ? 'active' : '' ?>">jobs</a></li>
		<li><a href="../forums/section" class="nav-link <?php echo $forumpage === true ? 'active' : '' ?>">forum</a></li>
		<li>
			<form action="../posts/search" method="POST">
				<input type="text" name="search" placeholder="SEARCH" class="search">
				<span class="focus-border"></span>
				<button type="submit" class="search-btn" name="submit"><i class="fa fa-search"></i></button>
			</form>
		</li>
	</ul>
</nav>