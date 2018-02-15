<?php
require_once '../core/init.php';
$db = DB::getInstance();
$store = new Store();
$partner = true;
if(Input::exists()){
 	if(Token::check(Input::get('token'))){ 
 		$validate = new Validation();
 		$validation = $validate->check($_POST,array(
 				'email' => array(
 					'required' => true,
 					'min' => 2,
 				),
 				'password' => array(
 					'required' => true,
 				),
 				'password_again' => array(
 					'required' => true,
 					'matches' => 'password'
 				),
 				'company_name' => array(
 					'required' => true,
 				),
  				'address' => array(
					'required' => true,
 					'min' => 2,
 				),
 				'telephone' => array(
 					'required' => true,
 				),
 			));
 		if($validation->passed()){
 			$salt = Hash::salt(32);
 			try{
 				$db->insert('partners',array(
 					'company_name' => Input::get('company_name'),
					'type' =>  Input::get('type'),
 					'number_year_operation' =>  Input::get('number_year_operation'),
 					'alumni_need' =>  Input::get('alumni_need'),
 					'type_of_company' => Input::get('type_of_company'),
 					'address' =>  Input::get('address'),
 					'industry' => Input::get('industry'),
 					'telephone' =>  Input::get('telephone'),
 					'website' =>  Input::get('website'),
 					'contact_person' =>  Input::get('contact_person'),
 					'job_title' =>  Input::get('job_title'),
 					'email' => Input::get('email'),
 					'password' => Hash::make(Input::get('password'),$salt),
 					'salt' => $salt,
 					'created_at' => date('Y-m-d H:i:s'),
 					));
 					Session::flash('registered','You have been registered You can now log in!');
 					Redirect::to('../jobs/partners_login.php');
 			}catch(Exception $e){
 				die($e->getMessage());
 			}
 		}else{
 			foreach ($validation->errors() as $error) {
 				echo $error ,"<br>";
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
	<div style="height:100px"></div>
			<p class="success">
				<?php 
					if(Session::exists('registered')){
						?>
						<script>
							swal({
							  title: "Success!",
							  text: "<?= Session::flash('registered'); ?>",
							  icon: "success",
							});
						</script>
						<?php
					}
				?>
			</p>	
			<form class="container" id="needs-validation" novalidate method="POST">
			  <div class="row">
			  	<div class="col-md-6">
			  		<h2 style="color:#27ae60"><i class="fa fa-plus-circle"></i> Register</h2>
			  		<div class="form-group">
					    <label for="validationCustom01">Company Name</label>
			  			<div class="input-group">
			  			  <div class="input-group-addon"><i class="fa fa-flag"></i></div>
					      		<input type="text" class="form-control" name="company_name" value="<?= escape(Input::get('company_name')); ?>" id="validationCustom01" placeholder="Company name" value="" required>
			  			</div>
			  		</div>
  			  		<div class="form-group">
  			  			<label for="validationCustom06">It is a</label>
  			  			<div class="input-group">
  			  				<div class="input-group-addon"><span class="">It is a</span></div>
  		  			          &nbsp;<input type="radio" name="type" value="private" checked="checked" id="male"  /> Private Company
  		  			          &nbsp;<input type="radio" name="type" value="public" id="female"/> Public Company
  			  			</div>
  			  		</div>

			  		<div class="form-group">
				      <label for="validationCustom03">Number of years in operation</label>
				      <div class="input-group">
				      	<div class="input-group-addon"><span class="fa fa-calendar"></span></div>
				      	<input type="text" class="form-control" id="validationCustom03" name="number_year_operation" value="<?= escape(Input::get('number_year_operation')); ?>" placeholder="No. of years in operation" value="" required>
				      </div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom05">No. of Alumni</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-graduation-cap"></span></div>
				  			<input type="text" class="form-control" id="validationCustom05" name="alumni_need" value="<?= escape(Input::get('alumni_need')); ?>" placeholder="(Optional) No. of Alumni">
			  			</div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom06"></label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-globe"></span></div>
		  			          &nbsp;<input type="radio" name="type_of_company" value="local" checked="checked" id="local"  /> Local
		  			          &nbsp;<input type="radio" name="type_of_company" value="international" id="international" =""/> International
			  			</div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom07">Address</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-map-marker"></span></div>
				  			<input type="text" class="form-control" id="validationCustom07" name="address" value="<?= escape(Input::get('address')); ?>" placeholder="Address" required>
			  			</div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom13">Inpdustry</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-tags"></span></div>
				  			<input type="text" class="form-control" id="validationCustom13" name="industry" value="<?= escape(Input::get('industry')); ?>" placeholder="Industry" required>
			  			</div>
			  			<div class="divider"></div>
			  			<!-- <span class="asterisk"><i class="fa fa-asterisk"></i> <small>Email is required</small></span> -->
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom14">Email</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-user"></span></div>
				  			<input type="email" class="form-control" id="validationCustom14" name="email" value="<?= escape(Input::get('email')); ?>" placeholder="Email" required>
			  			</div>
			  			<div class="divider"></div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom15">Password</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-lock"></span></div>
				  			<input type="password" class="form-control" id="validationCustom15" name="password" value="<?= escape(Input::get('password')); ?>" placeholder="Password" required>
			  			</div>
			  		</div>
			  		<div class="form-group">
			  			<label for="validationCustom15">Confirm Password</label>
			  			<div class="input-group">
			  				<div class="input-group-addon"><span class="fa fa-lock"></span></div>
				  			<input type="password" class="form-control" id="validationCustom15" name="password_again" value="<?= escape(Input::get('password_again')); ?>" placeholder="Confirm Password" required>
			  			</div>
			  		</div>
				  </div>
				  <div class="col-md-6">
				  	<h2 style="color:#27ae60"><i class="fa fa-phone"></i> Contact Information</h2>
	  			  	<div class="form-group">
	  			  		<label for="validationCustom08">Telphone</label>
	  			  		<div class="input-group">
	  			  			<div class="input-group-addon"><span class="fa fa-phone"></span></div>
		  			  		<input type="text" class="form-control" placeholder="Telphone #" id="validationCustom08" name="telephone" value="<?= escape(Input::get('telephone')); ?>" required>
	  			  		</div>
	  	   			      <div class="invalid-feedback">
	  				        Please provide a valid contact.
	  				   	   </div>
	  			  	</div>
	 
  				  	<div class="form-group">
  				  		<label for="validationCustom11">Website</label>
  				  		<div class="input-group">
  				  			<div class="input-group-addon"><span class="fa fa-globe"></span></div>
	  				  		<input type="text" class="form-control" placeholder="Website" id="validationCustom11" name="website" value="<?= escape(Input::get('website')); ?>" required>
  				  		</div>
  				  	</div>
	  			  	<div class="form-group">
	  			  		<label for="validationCustom09">Contact Person</label>
	  			  		<div class="input-group">
		  			  		<div class="input-group-addon"><b class="fa fa-user"></b></div>
		  			  		<input type="text" class="form-control" placeholder="Contact person" id="validationCustom09" name="contact_person" value="<?= escape(Input::get('contact_person')); ?>" required>
		  	   			      <div class="invalid-feedback">
		  				        Please provide a valid contact.
		  				   	  </div>
	  			  		</div>
	  			  	</div>
	  			  	<div class="form-group">
	  			  		<label for="validationCustom12">Position</label>
	  			  		<div class="input-group">
	  			  			<div class="input-group-addon"><span class="fa fa-id-card"></span></div>
		  			  		<input type="text" class="form-control" placeholder="Position/Job title" id="validationCustom12" name="job_title" value="<?= escape(Input::get('job_title')); ?>" required>
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
			  <button class="btn btn-success" type="submit">Submit</button>
			</form>
	<?php require_once '../functions/footer.php'; ?>
	<script src="../layouts/js/jquery-3.2.1.min.js"></script>
	<script src="../layouts/js/main.js"></script>
	<script>
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
	    var form = document.getElementById('needs-validation');
	    form.addEventListener('submit', function(event) {
	      if (form.checkValidity() === false) {
	        event.preventDefault();
	        event.stopPropagation();
	      }
	      form.classList.add('was-validated');
	    }, false);
	  }, false);
	})();
	</script>
</body>
</html>