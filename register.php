<?php
/*
 * register.php
 */
 
require_once 'core/init.php';
include('includes/header.php');


//var_dump(Token::check(Input::get('token')));

if(Input::exists()){
	
	//if(Token::check(Input::get('token'))){//this if statement is in the tut but seems to break functionality!, and the checks seem to work without it???
		
	//echo 'I have been run <br>'. Input::get('username');
	$validate = new Validate();
	$validation = $validate->check($_POST, array(
		'username' => array(
			'required' => true,
			'min' => 2,
			'max' => 18,
			'unique' => 'users'
		),
		'password' => array(
			'required' => true,
			'min' => 6
		),
		'password_again' => array(
			'required' => true,
			'matches' => 'password'
			
		),
		'name' => array(
			'required' => true,
			'min' => 2,
			'max' => 50
		)
	
	));
	
	if ($validation->passed()){//'Validation passed. '
		
		$user = new User();//instantiate User class, giving us access to database
		
		$salt = Hash::salt(32); //echo $salt; die;//test hash generation
		
		
		try{ // to register user
			$user->create(array(
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password'), $salt),
				'salt' => $salt,//storing the salt is crucial
				'name' => Input::get('name'),
				'joined' => date('Y-m-d H:i:s'),
				'group' => 1
			));
			
			Session::flash('success', 'You registered successfully');//store the flash message under 'success'
			Redirect::to('index.php');			
			//echo 'Return to <a href="index.php">index</a> to get the flash success message.';
		
		} catch(Exception $e){
			die($e->getMessage);
		} 
		
		//header('Location: index.php');//quick redirect doesn't work
	} else{ //validation not passed
		
		//print_r($validation->errors());
		foreach ($validation->errors() as $error){//error output
			echo '<span class="error" style="color: crimson;">'. $error .'</span><br>';
		}
	}
	//}end of commented out if statement

}
?>

<div class="main wrapper clearfix">
	<article class="grid">
		<section class="col-1-4">
			<form action="" method="post">
				<div>
					<label for="username">Choose a username:</label>
					<input type="text"  name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
				</div>
				<div>
					<label for="password">Choose a password:</label>
					<input type="password"  name="password" id="password">
				</div>
				<div>
					<label for="password_again">Please repeat the password:</label>
					<input type="password" name="password_again" id="password">
				</div>
				<div>
					<label for="Name">Enter your name:</label>
					<input type="text"  name="name" id="name" value="<?php echo escape(Input::get('name')); ?>">
				</div>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<input type="submit" value="Register">
				
				
				
			</form>
		</section>	
	</article>	
</div> <!-- #main -->

<?php include('includes/footer.php');
