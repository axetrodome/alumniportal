<?php 
require_once '../core/init.php';
$user = new User();
$store = new Store();
$forum = new Forum();
$forumpage = true;
if(Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validation();
		$validation = $validate->check($_POST,array(
			'topic' => array(
				'required' => true
			),
			'question' => array(
				'required' => true
			)
		));
		if($validation->passed()){
			try{
				$forum->create('questions',array(
					'user_id' => Input::get('user_id'),
					'topic' => Input::get('topic'),
					'question' => Input::get('question'),
					'time_elapsed' => time()
				));
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error,"<br>";
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
	<div style="padding-top:100px;min-height:500px;">
			<div class="permission-container">
		<?php if($user->isLoggedin()): ?>
				<button onclick="document.getElementById('id01').style.display='block'" class="btn-submit">Add Question <i class="fa fa-plus"></i></button>
		<?php else: ?>
				You need to <a href="../users/login">Login</a> or <a href="../users/register">Register</a> to add a question
		<?php endif; ?>
			</div>
		<div id="id01" class="modal">
			<form method="post" class="modal-content animate">
				<div class="col-3 input-effect">
					<input type="text" name="topic" class="input-medium effect-17" id="topic">
					<label for="topic" class="label">Topic</label>
					<span class="focus-medium"></span>
				</div>
				<div class="col-3 input-effect">
					<input type="text" name="question" class="input-medium effect-17" id="question">
					<label for="question" class="label">Question</label>
					<span class="focus-medium"></span>
				</div>
				<input type="hidden" name="user_id" value="<?= $user->data()->id; ?>">
				<input type="hidden" name="token" value="<?= Token::generate(); ?>">
				<div class="btn-container">
					<button type="submit" class="btn-submit">Add</button>
				</div>
			</form>
			</div>
		<div class="question-container">
			<div class="divider"></div>
			<h3>All Questions</h3>
			<?php 
			$page = !empty(Input::get('page')) ? (int)Input::get('page') : 1;
			$perPage = !empty(Input::get('per-page')) && Input::get('per-page') <= 50 ? (int)Input::get('per-page') : 15;
			// numbering
			$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;
			//get the content and pages
			$forum->page('questions',array($start,$perPage));
			$total = $forum->total();
			$pages = ceil($total/$perPage);
			foreach($forum->results() as $question): ?>
			<div class="questions">
				<a href="question?question=<?= $question->id ?>"><?= $question->topic; ?></a>
				<div class="answer">
				<?php if(strlen($question->question) > 300): ?>
					<p><?= $store->shortContent($question->question); ?>...</p>
				<?php else: ?>
					<p><?= $question->question ?></p>
				<?php endif; ?>
					<?php $user->get(array('id','=',$question->user_id)) ?>	
					<?php foreach($user->results() as $users): ?>
					<small class="simple-small">Asked by: <?= $users->first_name  ?> <?= $users->last_name  ?></small>
					<?php endforeach; ?>
					<br>
					<small class="simple-small">Asked <?= $store->time_elapsed($question->time_elapsed); ?></small><br>
				</div>
			</div>
			<div class="divider"></div>
			<div class="divider"></div>
		<?php endforeach; ?>
		</div>		
	</div>
	<div class="pagination">
	<!-- always start in 1 -->
		<?php for($x = 1;$x <= $pages; $x++): ?>
			<a href="?page=<?= $x; ?>&per-page=<?= $perPage ?>"<?php if($page === $x){echo "class='selected'";} ?>><?= $x; ?></a>
		<?php endfor; ?>
	</div>
	<?php require_once '../functions/footer.php'; ?>
	<script src="../layouts/js/jquery-3.2.1.min.js"></script>
	<script src="../layouts/js/main.js"></script>
	<script>
	// Get the modal
	var modal = document.getElementById('id01');
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	    }
	}
	</script>
</body>
</html>