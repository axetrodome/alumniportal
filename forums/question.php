<?php 
require_once '../core/init.php';
$user = new User();
$store = new Store();
$forum = new Forum();
$answer = new Answer();
$validate = new Validation();
$forumpage = true;
if(!$id = Input::get('question')){
	Redirect::to('..views/index.php');
}else{
		//check if POST and GET is not empty
	if(Input::exists()){
		if(Token::check(Input::get('token'))){
			$validation = $validate->check($_POST,array(
				'answer' => array(
					'required' => true
					)
				));
				if($validation->passed()){
					try{
						$forum->create('answers',
							array(
								'user_id' => Input::get('user_id'),
								'question_id' => Input::get('question_id'),
								'answer' => Input::get('answer'),
								'time_elapsed' => time()
							)
						);
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
<head>
	<?php require_once '../functions/header.php'; ?>
</head>
<body>
	<?php require_once '../functions/navigationbar.php' ?>
	<div style="min-height:500px">
		<?php $forum->selectAll('questions', array('id','=',$id)); ?>
		<?php foreach($forum->results() as $forum): ?>
			<div class="topic-content">
				<h2><?= $forum->topic; ?></h2>
				<p><?= $forum->question; ?></p>
				<?php $user->get(array('id','=',$forum->user_id)); ?>
				<?php foreach($user->results() as $users): ?>
					<small class="simple-small">Asked by: <?= $users->first_name ?> <?= $users->last_name ?></small><br>
				<?php endforeach; ?>
					<small class="simple-small">Asked <?= $store->time_elapsed($forum->time_elapsed) ?></small>
			</div>
			<div class="question-answers">
			<?php $answer->selectAll('answers', array('question_id','=',$forum->id)); ?>
				<?php foreach($answer->results() as $answer): ?>
					<?php $user->get(array('id','=',$answer->user_id)); ?>
					<?php foreach($user->results() as $users): ?>
						<div class="divider"></div>
						<p><?= $answer->answer ?></p>
						<small class="simple-small">Answered by: <?= $users->first_name ?> <?= $users->last_name ?></small><br>
					<?php endforeach; ?>
						<small class="simple-small">Answered <?= $store->time_elapsed($answer->time_elapsed) ?></small>
						<div class="divider"></div>
						<div class="divider"></div>
						<div class="divider"></div>
						<div class="divider"></div>
				<?php endforeach; ?>
			</div>
			<div class="answer-area">
			<?php if($user->isLoggedin()): ?>
					<form method="POST" action="">
						<h3 class="simple-small">Your Answer</h3>
						<div class="divider"></div>
						<textarea type="text" rows="8" cols="100" name="answer"></textarea>
						<input type="hidden" name="user_id" value="<?= $user->data()->id; ?>">
						<input type="hidden" name="question_id" value="<?= $forum->id ?>">
						<input type="hidden" name="token" value="<?= Token::generate(); ?>">
						<div class="divider"></div>
						<button type="submit" class="btn-submit">Post your Answer</button>
					</form>
				<div class="divider"></div>
				Browse other <a href="section">questions</a> or <a href="section">Ask your own question</a>
			<?php else: ?>
				You need to <a href="../users/login">Login</a> or <a href="../users/register">Register</a> to post answer
			<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php require_once '../functions/footer.php'; ?>
</body>
</html>
<?php 
	}
?>
