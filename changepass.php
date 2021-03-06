<?php 
/*
 * changepass.php
 */
require_once 'core/init.php';
include('includes/header.php');

$user = new User();
if (!$user->isLoggedIn()){
	Redirect::to('index.php');
}

if (Input::exists()){
	if(Token::check(Input::get('token'))){
		/*1 Validate current password, new password, new password again
		 */
		 $validate = new Validate();
		 $validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				//'min' => 6, //not really needed
			),
			'password_new' => array(
				'required' => true,
				'min' => 6,//certainly needed
			),
			'password_new_again' => array(
				'required' => true,
				//'min' => 6,//not really needed if we're matching anyway
				'matches' => 'password_new'
			)
		 ));
		 
		if($validation->passed()){
			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {//if a Hash made from the inputted current password and the user's salt DOES NOT match the current user's password in the db
				echo 'You entered the wrong current password. Please try again';
			} else {//they do match
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				));
				Session::flash('success', 'Your password has been changed');
				Redirect::to('index.php');
			}
		} else{
			foreach($validation->errors() as $error) {
				echo '<span class="error">'. $error .'</span><br>';
			}
		}
	}
	
} ?>
<div class="main wrapper clearfix">
	<article class="grid">
		<section class="col-1-1">
			<form action="" method="post">
				<div>
					<label for="password_current">Enter your current password:</label>
					<input type="password" name="password_current" id="password_current">
				</div>
				<div>
					<label for="password_new">Choose a new password:</label>
					<input type="password" name="password_new" id="password_new">
				</div>
				<div>
					<label for="password_new_again">Please repeat the new password:</label>
					<input type="password" name="password_new_again" id="password_new_again">
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Change">
			</form>
		</section>
	</article>
</div> <!-- #main -->	
<?php include('includes/footer.php');
