<?php
/*
 * index.php
 */
 
require_once 'core/init.php';

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
				echo 'success';
				
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
    </head>
    <body>

        <div class="header-container">
            <header class="wrapper clearfix">
                <h1 class="title upper">OPIUM</h1>
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
					<form action="" method="post">
						<div>
							<label for="username">Username</label>
							<input type="text" name="username" id="username" autocomplete="off">
						</div>
							<label for="password" >Password</label>
							<input type="password" name="password" id="password" autocomplete="off">
					
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
