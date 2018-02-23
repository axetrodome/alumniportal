<?php 
require_once '../core/init.php';
$partners = new Partner();
$partners_login = true;
$errors = [];
$loginErrs = [];
if($partners->isLoggedin()):
	Redirect::to('../views/index.php');
endif;
if(Input::exists()):
	if(Token::check(Input::get('token'))):

		$validate = new Validation();
		$validation = $validate->check($_POST,array(
			'email' => array('required' => true),
			'password' => array('required' => true)
			));
		if($validation->passed()):
			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $partners->login(Input::get('email'),Input::get('password'), $remember);
			if($login):
				Session::flash('logged','You are logged in!');
				Redirect::to('jobs.php');
			else:
				$loginErrs[] = 'Logging in failed.';
				$loginErrs[] = 'Wrong Username/Password or Your Account needs approval of the admin.';
			endif;
		else:
				$errors = $validation->errors();
		endif;
	endif;
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../layouts/bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="..layouts/bootstrap/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php require_once '../functions/navigationbar.php' ?>
	<div style="min-height:500px;" >
		<form action="" method="post" class="login-form" style="margin-top:150px">
			<?php foreach($errors as $error): ?>
			<div class="error">
				<?php echo $error ?>
			</div>
			<?php endforeach; ?>
			<?php foreach($loginErrs as $loginErr): ?>
			<div class="error">
				<?php echo $loginErr ?>
			</div>
			<?php endforeach; ?>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" id="email" placeholder="Email" autocomplete="off" class="form-control" value="<?php echo escape(Input::get('email'))?>">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" id="password" placeholder="Password"  autocomplete="off" class="form-control" >
				<span class="focus"></span>
			</div>
			<div class="form-check">
			  <label class="form-check-label">
			    <input type="checkbox" class="form-check-input" name="remember" id="remember">
			    Remember me
			  </label>
			</div>
			<div class="divider"></div>
			<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
			<input type="submit" value="Login" class="btn-submit">
			<div class="divider"></div>
			<div class="left-small">
				<small class="small">Don't have an account yet? <a href="partner.php">Register</a> </small>		
			</div>
		</form>
	</div>	
<?php require_once '../functions/footer.php'; ?>
<script src="../layouts/js/jquery-3.2.1.min.js"></script>
<script src="../layouts/js/main.js"></script>
</body>
</html>
