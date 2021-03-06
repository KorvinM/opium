<?php
/*
 * tests.php
 */
require_once 'core/init.php';
include('includes/header.php'); ?>

<div class="main wrapper clearfix">
	<article class="grid">
		<header>
			<h1>Tests</h1>
        </header>
		<section class="tests config">
			<div class="col-1-1">
				<h2>Config Tests</h2>
				<h3>Output values from the config global in init.php</h3>
				<p>
					<?php echo 'Cookie expiry time. echo: <span class="php-output">' . Config::get('remember/cookie_expiry') . '</span>';
					echo ' var_dump: <span class="php-output">';
					var_dump(Config::get('remember/cookie_expiry'));
					echo '</span>'; ?>
				<p>
					<?php echo 'session name. echo: <span class="php-output">' . Config::get('session/session_name') . '</span>';
					echo ' var_dump: <span class="php-output">';
					var_dump(Config::get('session/session_name'));
					echo '</span>'; ?>
				<p>
					<?php echo 'var_dump random false value foo/bar: <span class="php-output">';
				  var_dump(Config::get('foo/bar'));
					echo '</span>';
					?>
				<p>var_dump an empty value only returns false:
					<span class="php-output"> <?php var_dump( Config::get('') ); ?>
					</span>
			</div>
        </section>
		<section class="tests db">
			<div class="col-1-1">
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
			</div>
			<div class="col-1-1">
				<h3>Basic method tests</h3>
				<p>First test: prepare and execute query<br>
					<code>
						<pre>$users = DB::getInstance()->query('SELECT username FROM users');
if($users->count()){
	echo 'Query prepared and executed';
}</pre></code>
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
}</pre></code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->query("SELECT username FROM users WHERE username =?", array('billy'));
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
}</pre></code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->get('users',array('username','=','billy'));
					if($user->count()){
						echo 'Found user';
					} else{
						echo 'No user found';
					}
					echo '</span>';
				?>
			</div>

			<div class="col-1-2">
			<h3>Read Data</h3>
			<p>get all users with standard sql query:<br>
				<code><pre>$user = DB::getInstance()->query("SELECT * FROM users");
if($user->count()){
	foreach($user->results() as $user){
		echo $user->username;
		echo ' ';
	}
	}else{
		echo 'No user found';
}</pre></code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->query("SELECT * FROM users");
					if($user->count()){
						foreach($user->results() as $user){
							echo $user->username;
							echo ' ';
						}
					}else{
						echo 'No user found';
					}
					echo '</span>'; ?>

			<p>Getting the first 'billy' result.<br>
				<code><pre>$user = DB::getInstance()->get('users',array('username','=','billy'));
if($user->count()){
	echo $user->first()->username;
} else{
	echo 'No user found';
}</pre></code>
				<?php
					echo '<span class="php-output">';
					$user = DB::getInstance()->get('users',array('username','=','billy'));
					if($user->count()){
						echo $user->first()->username;
					} else{
						echo 'No user found';
					}
					echo '</span>';
				?>

			</div>
			<div class="col-1-2">
			<h3>Insert and Update Data</h3>
			<p>The code to insert data would be something like:<br>
				<code><pre>$user = DB::getInstance()->insert('users', array(
	'username' => 'Dale',
	'password' => 'unpassword',
	'salt' => 'basalt'
));</pre></code>

			<p>The following code will update user 3's password:<br>
				<code><pre>$user = DB::getInstance()->update('users',3, array(
	'password' => 'updatedpassword',
));</pre></code>
	</div>
		</section>
	</article>
</div> <!-- #main -->

<?php include('includes/footer.php');
