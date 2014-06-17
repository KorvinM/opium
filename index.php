<?php
/*
 * index.php
 */

require_once 'core/init.php'; 
include('includes/header.php');
?>

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
			<br>To var_dump 'foo/bar' would reveal the contents of the <code>$GLOBALS['config']</code> variable.<br>
			The codebase could be improved to test against this case!
			<p>var_dump an empty value only returns false: 
			<span class="php-output"> <?php var_dump( Config::get('') ); ?></span>
								 
                           
		</section>
		<section class="col-1-2">
			<h2>Database tests</h2>
			<h3>Test Connection to DB class</h3>
			<span class="php-output">
				<?php if(class_exists('DB')){//http://stackoverflow.com/questions/22064419/trying-to-figure-out-how-to-check-if-an-class-has-been-instantiated
					DB::getInstance();
                    echo 'Connected';
                 } else{
                    echo 'Not connected';
                 } ?>
            </span>


			<h3>Basic method tests</h3>
			<p>First test: prepare and execute query<br>
			<code><pre>$users = DB::getInstance()->query('SELECT username FROM users');
	if($users->count()){
		echo 'Query prepared and executed';
	}</pre>	</code> 
						    
						    
				<?php 
					echo '<span class="php-output">';
					$users = DB::getInstance()->query('SELECT username FROM users');
						if($users->count()){
							echo 'Query prepared and executed';
						}
					echo '</span>';
				?>
							
			<p>Second Test: look for billy<br>
				<code><pre>$user = DB::getInstance()->query("SELECT username FROM users WHERE username =?", array('billy'));
	if($user->count()){
		echo 'Found user';
	} else{
		echo 'No user found';	
	}</pre>		</code>
							
				<?php 
					echo '<br><span class="php-output">';
					$user = DB::getInstance()->query("SELECT username FROM users WHERE username =?", array('billy'));
					echo '<br>';
					if($user->count()){
						echo 'Found user';
									
					} else{
						echo 'No user found';	
					}
					echo '</span>';
				?>
			<p>Third Test:get billy<br>
				<code><pre>$user = DB::getInstance()->get('users',array('username','=','billy'));
	if($user->count()){
		echo 'Found user';
	} else{
		echo 'No user found';	
	}</pre>		</code> 
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->get('users',array('username','=','billy'));
					echo '<br>';
					if($user->count()){
						echo 'Found user';
					} else{
						echo 'No user found';	
					}
					echo '</span>';
				?>
			<h3>Read Data</h3> 
			<p>get all users with standard sql query:<br>
				<code><pre>$user = DB::getInstance()->query("SELECT * FROM users");
	if($user->count()){
		foreach($user->results() as $user){
			echo $user->username;
		}
		}else{
			echo 'No user found';	
	}</pre>		</code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->query("SELECT * FROM users");
					if($user->count()){
						foreach($user->results() as $user){
							echo $user->username;
						}
					}else{
						echo 'No user found';	
					}	
								
					echo '</span>';?>
							
			<p>Getting the first 'billy' result.<br>
				<code><pre>$user = DB::getInstance()->get('users',array('username','=','billy'));
	if($user->count()){
		echo $user->first()->username;	
	} else{
		echo 'No user found';	
	}</pre>		</code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->get('users',array('username','=','billy'));
					echo '<br>';
					if($user->count()){
						echo $user->first()->username;	
					} else{
						echo 'No user found';	
					}
					echo '</span>';
				?>
			<h3>Insert and Update Data</h3>
			<p>The code to insert data would be something like:<br> 
				<code><pre>$user = DB::getInstance()->insert('users', array(
	'username' => 'Dale',
	'password' => 'unpassword',
	'salt' => 'basalt'
	));</pre>	</code>
							
			<p>The following code will update user 3's password:<br>
				<code><pre>$user = DB::getInstance()->update('users',3, array(
	'password' => 'updatedpassword',
	));</pre>	</code>	
		
		</section>
		<section class="col-1-1">
			<p><a href="register.php">Proceed to Register</a>
			If registration is successful,  tests run below should output 'You registered successfully' on first return to this page.
				<?php 
				if (Session::exists('success')){
					echo '<p class="php-output flash">';
					echo Session::flash('success');
					echo '</p>';
				} ?>
			<p>Session:
				<?php echo '<span class="php-output">'; 
				echo Session::get(Config::get('session/session_name')); 
				echo '</span>';
				$user = new User();
				if($user->isLoggedIn()){
					echo '<span class="php-output">Logged in</span>';
				?>
			<p>Hello <a href="#"><?php echo escape($user->data()->username); ?></a>
				<ul>
					<li><a href="logout.php">Log out</a></li>
					<li></li>
				</ul>
				<?php	
				} else{
					echo '<span class="php-output">Logged out</span><p>Please <a href="login.php">log in</a> or <a href="register.php">register</a>.</p>';
				}
					
				?>
					
				
		</section>
	</article>	
</div> <!-- #main -->
        
<?php include('includes/footer.php');