<?php 
require_once '../core/init.php';
$user = new User();
$login = true;
if($user->isLoggedin()){
	Redirect::to('../views/index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php require_once '../functions/navigationbar.php' ?>
	<div style="min-height:500px;" >
		<form action="" method="post" class="login-form" style="margin-top:150px">
				<?php
				if(input::exists()){
					if(Token::check(Input::get('token'))){

						$validate = new Validation();
						$validation = $validate->check($_POST,array(
							'username' => array('required' => true),
							'password' => array('required' => true)
							));
						if($validation->passed()){
							$remember = (Input::get('remember') === 'on') ? true : false;
							$login = $user->login(Input::get('username'),Input::get('password'), $remember);

							if($login){
								Session::flash('logged','You are logged in!');
								Redirect::to('../views/index.php');
							}else{
								echo '<p class="error">Logging in failed.</p>';
								echo '<small class="error">Wrong Username/Password or Your Account needs approval of the admin.</small>';
							}
						}else{
							foreach ($validation->errors() as $error) {
								echo $error,'<br>';
							}
						}
					}
				}
				?>
			<div class="input-effect col-3">
				<input type="text" name="username" id="username" required autocomplete="off" class="input effect-17" value="<?php echo escape(Input::get('username'))?>">
				<label for="username" class="label">Username</label>
				<span class="focus"></span>
			</div>
			<div class="input-effect col-3">
				<input type="password" name="password" id="password" required autocomplete="off" class="input effect-17">
				<label for="password" class="label">Password</label>
				<span class="focus"></span>
			</div>
			<label for="remember">
				<input type="checkbox" name="remember" id="remember"> Remember me
			</label>
			<div class="divider"></div>
			<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
			<input type="submit" value="Login" class="btn-submit">
			<div class="divider"></div>
			<div class="left-small">
				<small class="small">Don't have an account yet? <a href="register.php">Register</a> </small>		
			</div>
		</form>
	</div>	
<?php require_once '../functions/footer.php'; ?>
<script src="../layouts/js/jquery-3.2.1.min.js"></script>
<script src="../layouts/js/main.js"></script>
</body>
</html>
