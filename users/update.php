<?php 
require_once '../core/init.php';
$url =  "{$_SERVER['REQUEST_URI']}";
$store = new Store();
$user = new User();
$update = true;

if(!$user->isLoggedin()){
	Redirect::to('../views/index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validation();
		$validation = $validate->check($_POST,array(
			'email' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
				),
			'email' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'first_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'last_name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'address' => array(
				'required' => true
			),
			'nationality' => array(
				'required' => true
			),
			));
		if($validation->passed()){
			try{
				$user->update(array(
					'email' => Input::get('email'),
					'username' => Input::get('username'),
					'email' => Input::get('email'),
					'first_name' =>  Input::get('first_name'),
					'middle_name' =>  Input::get('middle_name'),
					'last_name' =>  Input::get('last_name'),
					'address' =>  Input::get('address'),
					'birthday' => Input::get('birthday'),
					'gender' => Input::get('gender'),
					'cellphone' =>  Input::get('cellphone'),
					'telephone' =>  Input::get('telephone'),
					'nationality' =>  Input::get('nationality'),
					'company' =>  Input::get('company'),
					'position' =>  Input::get('position'),
					'year_graduated' =>  Input::get('year_graduated'),
					));
				Session::flash('updated','your details has been updated');
				Redirect::to("{$url}");
			}catch(Exception $e){
				die($e->getMessage(	));
			}
		}else{
			foreach ($validation->errors() as $error) {
				Session::flash('error',"{$error}");
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
	<div style="min-height:1500px">
		<form action="" method="post" class="change-form">
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
			<div class="col-3 input-effect">
				<input type="text" name="email" id="email" value="<?php echo escape($user->data()->email); ?>" class="input effect-17">
				<label for="email" class="label" style="z-index:-2">Email</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="username" id="username" value="<?php echo escape($user->data()->username); ?>" class="input effect-17">
				<label for="username" class="label" style="z-index:-2">Useername</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="first_name" id="first_name" value="<?php echo escape($user->data()->first_name); ?>" class="input effect-17">
				<label for="first_name" class="label" style="z-index:-2">First name</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="middle_name" id="middle_name" value="<?php echo escape($user->data()->middle_name); ?>" class="input effect-17">
				<label for="middle_name" class="label" style="z-index:-2">Middle name</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="last_name" id="last_name" value="<?php echo escape($user->data()->last_name); ?>" class="input effect-17">
				<label for="last_name" class="label" style="z-index:-2">Last name</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="address" id="address" value="<?php echo escape($user->data()->address); ?>" class="input effect-17">
				<label for="address" class="label" style="z-index:-2">Address</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="date" name="birthday" id="birthday" value="<?php echo escape($user->data()->birthday); ?>" class="input effect-17">
				<label for="birthday" class="label" style="z-index:-2">Birthday</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="gender" id="gender" value="<?php echo escape($user->data()->gender); ?>" class="input effect-17">
				<label for="gender" class="label" style="z-index:-2">Gender</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="cellphone" id="cellphone" value="<?php echo escape($user->data()->cellphone); ?>" class="input effect-17">
				<label for="cellphone" class="label" style="z-index:-2">Cellphone</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="telephone" id="telephone" value="<?php echo escape($user->data()->telephone); ?>" class="input effect-17">
				<label for="telephone" class="label" style="z-index:-2">Telephone</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="nationality" id="nationality" value="<?php echo escape($user->data()->nationality); ?>" class="input effect-17">
				<label for="nationality" class="label" style="z-index:-2">Nationality</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="company" id="company" value="<?php echo escape($user->data()->company); ?>" class="input effect-17">
				<label for="company" class="label" style="z-index:-2">Company</label>
				<span class="focus"></span>
			</div>
			<div class="col-3 input-effect">
				<input type="text" name="position" id="position" value="<?php echo escape($user->data()->position); ?>" class="input effect-17">
				<label for="position" class="label" style="z-index:-2">Position</label>
				<span class="focus"></span>
			</div>
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<a href="../views/index.php" class="btn-cancel">Cancel</a>
			<input type="submit" name="Update" class="btn-submit">
		</form>
	</div>
	<?php require_once '../functions/footer.php'; ?>
</body>
</html>
