<?php
/*
 * update.php
 */
require_once 'core/init.php';
include('includes/header.php');

$user = new User();
if(!$user->isLoggedIn()){
	Redirect::to('index.php');
}

if (Input::exists()){
	if(Token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name'=>array(
				'required' => true,
				'min' => 2,
				'max' => 50,
			)
		));
		
		if($validation->passed()){
			$nuName = Input::get('name');
			try{
				$user->update(array(
					'name' => $nuName
				));
				Session::flash('success','Your name has been changed to ' . escape($nuName));//just the input, doesn't get updated value from db
				Redirect::to('index.php');
			} catch(Exception $e){//php.net/manual/en/exception.getmessage.php
				die($e->getMessage());//die -Equivalent to exit - php.net/manual/en/function.die.php 
			}
		} else{
			foreach($validation->errors() as $error){
				echo '<span class="error">'. $error .'</span><br>';
			}
		}
	}
	
} ?>
<div class="main wrapper clearfix">
	<article class="grid">
		<section class="col-1-4">
			<form action="" method="post">
				<div>
					<label for="name">Change your name:</label>
					<input type="text"  name="name" id="name" value="<?php echo escape($user->data()->name); ?>"><!--this could be ghost content -->
					<input type="submit" value="Update">
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				</div>				
			</form>
		</section>	
	</article>	
</div> <!-- #main -->

<?php include('includes/footer.php');
