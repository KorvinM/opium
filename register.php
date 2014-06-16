<?php
/*
 * register.php
 */
 
require_once 'core/init.php';

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
		
		if ($validation->passed()){
			// register user
			echo 'You passed';
		} else{
			//error output
			//print_r($validation->errors());
			foreach ($validation->errors() as $error){
				echo '<span class="error" style="color: crimson;">'. $error .'</span><br>';
			}
		}
	//}end of commented out if statement
	
}


?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>OPIUM</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="//brick.a.ssl.fastly.net/Roboto:400">
        <link href='' rel='stylesheet' type='text/css'>
        <link href='' rel='stylesheet' type='text/css'>
        <link href='' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="opicon.ico" type="image/x-icon" sizes="64x64"/>
    </head>
    <body>

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="upper"><a class="title" href="index.php">OPIUM</a></h1>
                <h2 class="subtitle"> Object-oriented Php Intuitive User Manager</h2>
                <!--<nav>
                  <ul>
				
					  
				  </ul>
                </nav>-->
                
            </header>
        </div>
        <h3 class="dright upper">Application prototype based on a php academy tutorial </h3>
        <div class="main-container">
			
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
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper upper">
         
            </footer>
        </div>
		

        <script src="js/main.js"></script>
    </body>
</html>
