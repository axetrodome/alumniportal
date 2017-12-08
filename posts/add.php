<?php
require_once '../core/init.php';
$post = new Post();
$user = new User();
if(!$user->isLoggedin() && !$user->hasPermission('admin')){
	Redirect::to('../views/index.php');
}
if(Input::exists()){
	if(Token::check(Input::get('token'))){ 
		$validate = new Validation();
		$validation = $validate->check($_POST,array(
			'content' => array(
				'required' => true
				)
			));
		if($validation->passed()){
			try{
				$post->create(array(
					'content' => Input::get('content'),
					'time_elapsed' => time()
					));
			}catch(Exception $e){
				die($e->getMessage());
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
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<title>Alumni Portal</title>
	<script src="../ckeditor/ckeditor.js"></script>
</head>
<body>
	<form action="" method="post">
		<div class="field">
			<textarea type="text" name="content" id="content" class="ckeditor"></textarea><br>
		</div>
		<!-- always include token -->
		<input type="hidden" name="token" value="<?php echo Token::generate() ?>">
		<button type="submit">Post</button>
	</form>
	<a href="../views/index.php">Home</a>
</body>
</html>