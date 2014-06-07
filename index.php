<?php
/*
 * index.php
 */
 
require_once 'core/init.php'; ?>

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
        <style>
			body{background: #e9e6e8;color: #061212; 
				font-size: 1em;}
			h1, h2, h3, .php-output{font-family: Roboto, sans-serif;font-weight: 300;}
			h1{font-size: 1.27em; line-height: 1em;
				margin-bottom: 1em;}
			h2{font-size: 1.125em; line-height: 1.2em;
			margin-top: 1em; margin-bottom: 1em;}
			h3{font-size: 1em;}
			
			h2,h3{font-family: "Gill Sans MT", sans-serif;}
			.header-container{border-radius: 3em 0; background: #cbc8c9;}
			.header-container>header>*{display: inline-block;}
			.title{color: #121212; text-shadow: #061212 0.6px -0.3px 1.6px; letter-spacing: 0.1em; padding: 0 1em;font-size: 1.42em;  line-height: 0.62em;
  margin-top: 1.9em;
  margin-bottom: 0.9em;}
            .subtitle{font-variant: small-caps;!important}
            .upper{text-transform: uppercase;}
			.main-container{margin: 0 0.1em 0 0.37em;}
			.php-output{background: none repeat scroll 0 0 #1f1e1c;
						border-radius: 0.3em;
						color: #ebeaee;
						display: inline-block;
						font-size: 0.9em;
						font-weight: normal;
						margin-top: 0.2em;
						padding: 0.18em 0.62em;}
			.dright {float:right; text-align:right;}
			@media (min-width: 45em){
				.main-container{margin-left: 1.62em;}
			}	
		</style>

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
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
					 <header>
                        <h1>Tests</h1>
                    </header>
					<section class="col-1-2">
						<h2>Config Tests</h2>
						<h3>Output values from the config global in init.php</h3>
                            <p>
							<?php echo 'echo cookie expiry time: <span class="php-output">' . Config::get('remember/cookie_expiry') . '</span>';
							echo '<br>var_dump same: <span class="php-output">';
							var_dump(Config::get('remember/cookie_expiry')); 
							echo '</span>'; ?>
							<p>
							<?php echo 'echo session name: <span class="php-output">' . Config::get('session/session_name') . '</span>';
							echo '<br>var_dump same: <span class="php-output">';
							var_dump(Config::get('session/session_name')); 
							echo '</span>'; ?>
							<p>
							<?php echo 'echo random false value foo/bar: <span class="php-output">' . Config::get('foo/bar') . '</span>'; ?>
							To var_dump 'foo/bar' would reveal the contents of the <code>$GLOBALS['config']</code> variable.
                            <p>var_dump an empty value returns false: 
								<span class="php-output"> <?php var_dump( Config::get('') ); ?></span>
                            
						</p>
					</section>
					<section class="col-1-2">
						<h2>Database tests</h2>
						<h3>Test Connection to DB class</h3>
						<?php DB::getInstance(); ?>

						<h3>Basic method tests</h3>
						    <p>
							<?php 
							echo 'First test: <span class="php-output">';
							$users = DB::getInstance()->query('SELECT username FROM users');
							if($users->count()){
									foreach($users as $user){
										echo $user->username;
									}
							}
							echo '</span>';
							
							echo '<br>Second Test: <span class="php-output">';
							$user = DB::getInstance()->query("SELECT username FROM users WHERE username =?", array('jon'));
							echo '</span>';
							
							echo '<br>Third Test: <span class="php-output">';
							$user = DB::getInstance()->get('users',array('username','=','jon'));
							echo '<br>';
							if($user->count()){
									
								echo 'Found user';
									
							} else{
								echo 'No user found';	
							}
							echo '</span>';
							
							?>
						<h3>Data</h3> 
						<p>
						<?php 
						echo 'get all users with standard sql query:<br><span class="php-output">';
						$user = DB::getInstance()->query("SELECT * FROM users");
						if($user->count()){
									
							foreach($users as $user){
								echo $user->username;
							}
						}else{
								echo 'No user found';	
							}	
							
						echo '</span>';
						/*echo '<br>Get first result<span class="php-output">';
							$user = DB::getInstance()->get('users',array('username','=','jon'));
							echo '<br>';
							if($user->count()){
									
								echo $user->first()->username;
									
							} else{
								echo 'No user found';	
							}
							echo '</span>';
							* */
						?>
					
					</section>
				</article>	
			</div> <!-- #main -->
        </div> <!-- #main-container -->

        <div class="footer-container">
            <footer class="wrapper upper">
         
            </footer>
        </div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/main.js"></script>
    </body>
</html>
