<?php
/*
 * index.php
 */
 
require_once 'core/init.php';
include('includes/header.php');

if(Input::exists()){
	if(Token::check(Input::get('token'))){
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array('required' => true),
			'password' => array('required' => true)
		));
		
		if($validation->passed()){
			//log user in
			$user = new User();
			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'));
			if($login){
				Redirect::to('index.php');
				
			} else{
				echo 'fail';
			}
			
			
		} else{
			foreach ($validation->errors() as $error){//error output
				echo '<span class="error" style="color: crimson;">'. $error .'</span><br>';
			}
		}
	
	}
	
}
?>

			
<div class="main wrapper clearfix">
	<article class="grid">
		<form action="" method="post">
			<div>
				<label for="username">Username</label>
				<input type="text" name="username" id="username" autocomplete="off">
			</div>
			<div>
				<label for="password" >Password</label>
				<input type="password" name="password" id="password" autocomplete="off">
			</div>
			<div>
				<label for="remember"><!--input inside label ensures the text is clickable as well as the checkbox -->
					<input type="checkbox" name="remember" id="remember">
					<span>Remember Me</span>
				</label>
			</div>		
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Log In">
					
		</form>
	</article>	
</div> <!-- #main -->

<?php include('includes/footer.php');
