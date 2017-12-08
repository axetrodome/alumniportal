<?php
require_once '../core/init.php';
$user = new User();
$store = new Store();
$changepass = true;
$url = "{$_SERVER['REQUEST_URI']}";
if(!$user->isLoggedin()){
	Redirect::to('../views/index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate  = new Validation();
		$validation = $validate->check($_POST,array(
			'password_current' => array(
				'required' => true,
				'min' => 6
				),
			'password_new' => array(
				'required' => true,
				'min' => 6
				),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
				)
			));
		if($validation->passed()){

			if(Hash::make(Input::get('password_current'),$user->data()->salt) !== $user->data()->password){
				echo 'Your current password is wrong';
			}else{
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'),$salt),
					'salt' => $salt
					));
				Session::flash('success','Your password has been updated!');
				Redirect::to("{$url}");			
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error,'<br>';
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php require_once '../functions/navigationbar.php' ?>
	<div style="min-height:500px;">
		<p class="success">
			<?php 
				if(Session::exists('updated')){
					?>
					<script>
						swal({
						  title: "Success!",
						  text: "<?= Session::flash('updated'); ?>",
						  icon: "success",
						});
					</script>
					<?php
				}
			?>
		</p>
		<form action="" method="post" class="change-form">
			<h2 style="color:#27ae60"><i class="fa fa-lock"></i> Change password</h2>
			<div class="input-effect col-3">
				<input type="password" name="password_current" id="password_current" value="" class="input effect-17">
				<label for="password_current" class="label">Current password</label>
				<span class="focus"></span>
			</div>
			<div class="input-effect col-3">
				<input type="password" name="password_new" id="password_new" value="" class="input effect-17">
				<label for="password_new" class="label">New password</label>
				<span class="focus"></span>
			</div>	
			<div class="input-effect col-3">
				<input type="password" name="password_new_again" id="password_new_again" value="" class="input effect-17">
				<label for="password_new_again" class="label">New password again</label>
				<span class="focus"></span>
			</div>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<a href="../views/index.php" class="btn-cancel">Cancel</a>
			<input type="submit" class="btn-submit" value="Change">
		</form>
		
	</div>
<?php require_once '../functions/footer.php'; ?>
<script src="../layouts/js/jquery-3.2.1.min.js"></script>
<script src="../layouts/js/main.js"></script>
</body>
</html>