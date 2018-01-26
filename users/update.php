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
	<link rel="stylesheet" href="../layouts/bootstrap/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="..layouts/bootstrap/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</head>
<body>
	<?php require_once '../functions/navigationbar.php' ?>
	<div style="min-height:1500px">
		<form class="container" id="needs-validation" novalidate method="POST">
					  <div class="row">
					  	<div class="col-md-6">
					  		<h2 style="color:#27ae60"><i class="fa fa-user"></i> Personal details</h2>
					  		<div class="form-group">
							    <label for="validationCustom01">First name</label>
					  			<div class="input-group">
					  			  <div class="input-group-addon"><i class="fa fa-user"></i></div>
							      		<input type="text" class="form-control" name="first_name" value="<?= escape($user->data()->first_name); ?>" id="validationCustom01" placeholder="First name" value="" required>
					  			</div>
					  		</div>

			  		  		<div class="form-group">
			  			      <label for="validationCustom02">Middle name</label>
			  			      <div class="input-group">
			  			      	  <div class="input-group-addon"><span class="fa fa-align-center"></span></div>
				  			      <input type="text" class="form-control" id="validationCustom02" name="middle_name" value="<?= escape($user->data()->middle_name); ?>" placeholder="Middle name" value="" required>
			  			      </div>
			  		  		</div>	

					  		<div class="form-group">
						      <label for="validationCustom03">Last name</label>
						      <div class="input-group">
						      	<div class="input-group-addon"><span class="fa fa-bookmark"></span></div>
						      	<input type="text" class="form-control" id="validationCustom03" name="last_name" value="<?= escape($user->data()->last_name); ?>" placeholder="Last name" value="" required>
						      </div>
					  		</div>
					  		<div class="form-group">
					  			<label for="validationCustom05">Birthday</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-calendar"></span></div>
						  			<input type="date" class="form-control" id="validationCustom05" name="birthday" value="<?= escape($user->data()->birthday); ?>" required>
					  			</div>
					  		</div>
					  		<div class="form-group">
					  			<label for="validationCustom06">Gender</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-random"></span></div>
				  			          &nbsp;<input type="radio" name="gender" value="male" <?php echo $user->data()->gender === 'male' ? 'checked="checked"' : '' ?> id="male"  /> Male
				  			          &nbsp;<input type="radio" name="gender" value="female" id="female" <?php echo $user->data()->gender === 'female' ? 'checked="checked"' : ''?> /> Female
					  			</div>
					  		</div>
					  		<div class="form-group">
					  			<label for="validationCustom07">Nationality</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-flag"></span></div>
						  			<input type="text" class="form-control" id="validationCustom07" name="nationality" value="<?= escape($user->data()->nationality); ?>" placeholder="Nationality" required>
					  			</div>
					  		</div>
					  		<div class="form-group">
					  			<label for="course">Course</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-book"></span></div>
						  			<input type="text" class="form-control" id="course" name="course" value="<?= escape($user->data()->course); ?>" placeholder="Course" required>
					  			</div>
					  		</div>
					  		<h2 style="color:#27ae60"><i class="fa fa-lock"></i> Account Details</h2>
					  		<div class="form-group">
					  			<label for="validationCustom13">Email</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-envelope"></span></div>
						  			<input type="email" class="form-control" id="validationCustom13" name="email" value="<?= escape($user->data()->email); ?>" placeholder="Email" required>
					  			</div>
					  			<div class="divider"></div>
					  			<span class="asterisk"><i class="fa fa-asterisk"></i> <small>Email is required</small></span>
					  		</div>
					  		<div class="form-group">
					  			<label for="validationCustom14">Username</label>
					  			<div class="input-group">
					  				<div class="input-group-addon"><span class="fa fa-user"></span></div>
						  			<input type="text" class="form-control" id="validationCustom14" name="username" value="<?= escape($user->data()->username); ?>" placeholder="Username" required>
					  			</div>
					  			<div class="divider"></div>
					  			<span class="asterisk"><i class="fa fa-asterisk"></i> <small>Username is required</small></span>
					  		</div>
				    		<div class="form-group">
				    			<label for="validationCustom15">Username</label>
				    			<div class="input-group">
				    				<div class="input-group-addon"><span class="fa fa-user"></span></div>
				  	  			<input type="text" class="form-control" id="validationCustom15" name="year_graduated" value="<?= escape($user->data()->year_graduated); ?>" placeholder="Year Graduated" required>
				    			</div>
				    			<div class="divider"></div>
				    			<span class="asterisk"><i class="fa fa-asterisk"></i> <small>Username is required</small></span>
				    		</div>
						  </div>
						  <div class="col-md-6">
						  	<h2 style="color:#27ae60"><i class="fa fa-phone"></i> Contact Information</h2>
			  			  	<div class="form-group">
			  			  		<label for="validationCustom08">Telphone</label>
			  			  		<div class="input-group">
			  			  			<div class="input-group-addon"><span class="fa fa-phone"></span></div>
				  			  		<input type="text" class="form-control" placeholder="Telphone # (Optional)" id="validationCustom08" name="telephone" value="<?= escape($user->data()->telephone); ?>">
			  			  		</div>
			  	   			      <div class="invalid-feedback">
			  				        Please provide a valid contact.
			  				   	   </div>
			  			  	</div>
			  			  	<div class="form-group">
			  			  		<label for="validationCustom09">Cellphone</label>
			  			  		<div class="input-group">
				  			  		<div class="input-group-addon"><b class="fa fa-mobile"></b></div>
				  			  		<input type="text" class="form-control" placeholder="09********* (Optional)" id="validationCustom09" name="cellphone" value="<?= escape($user->data()->telephone); ?>">
				  	   			      <div class="invalid-feedback">
				  				        Please provide a valid contact.
				  				   	  </div>
			  			  		</div>
			  			  	</div>
					  		<div class="form-group">
						      <label for="validationCustom010">Address</label>
						      <div class="input-group">
						      		<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
							      <input type="text" class="form-control" id="validationCustom010" name="address" value="<?= escape($user->data()->address); ?>" placeholder="Address">
						      </div>
						      <small class="col-md-4">(Block #, Lot #, House #, Street, Subd./Village, Brgy.)</small>
						   		<div class="invalid-feedback">
						        Please provide a valid Address.
						   	   </div>
					  		</div>
					  		<h2 style="color:#27ae60"><i class="fa fa-briefcase"></i> Employment Details</h2>
		  				  	<div class="form-group">
		  				  		<label for="validationCustom11">Company</label>
		  				  		<div class="input-group">
		  				  			<div class="input-group-addon"><span class="fa fa-building"></span></div>
			  				  		<input type="text" class="form-control" placeholder="Company (Optional)" id="validationCustom11" name="company" value="<?= escape($user->data()->telephone); ?>">
		  				  		</div>
		  				  	</div>
			  			  	<div class="form-group">
			  			  		<label for="validationCustom12">Position</label>
			  			  		<div class="input-group">
			  			  			<div class="input-group-addon"><span class="fa fa-id-card"></span></div>
				  			  		<input type="text" class="form-control" placeholder="Position (Optional)" id="validationCustom12" name="position" value="<?= escape($user->data()->position); ?>">
			  			  		</div>
			  			  	</div>
						  </div>
					  	</div>
					  <small>I hereby certify that all the information provided are true and correct.</small><br>
					  <small>Your registration need to approve by the admin. please wait</small><br>
					  <div class="divider"></div>
					  <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
					  <div class="left-small">
					  	<small class="small">Already have an account? <a href="login">Login</a> </small>		
					  </div>
			  		  <a href="../views/index" class="btn btn-danger">Cancel</a>
					  <button class="btn btn-success" type="submit">Update</button>
					</form>
	</div>
	<?php require_once '../functions/footer.php'; ?>
</body>
</html>
