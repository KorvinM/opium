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
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Log In">
					
		</form>
	</article>	
</div> <!-- #main -->


</div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper upper">
         
            </footer>
        </div>
		

        <script src="js/main.js"></script>
    </body>
</html>
