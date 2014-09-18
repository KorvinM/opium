<?php
/*
 * index.php
 */

require_once 'core/init.php'; 
include('includes/header.php');


/*if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	echo 'Remember Me is in effect!!!';	
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash','=', $hash));
	
	if($hashCheck->count()){
		echo 'Hash matches, log user in';
	} 
}*/
//^temporay check during development of 'Remember Me' functionality

?>
<div class="main wrapper clearfix">
	<article class="grid">
		<header>
			<h1>Opium Den</h1>
        </header>
        
        <section class="links">
			<a href="tests.php">Tests</a>
		</section>	

		<section class="col-1-1">
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
					echo '<span class="php-output">Logged in</span>'; ?>
					<p>Hello <?php echo escape($user->data()->name); ?>, your username is: <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?></a>
					
<?php
				
					if($user->hasPermission('admin') && $user->hasPermission('moderator')){
						echo '<p>You are an administrator and a moderator</p>';
					}  elseif($user->hasPermission('admin')){
						echo '<p>You are an administrator</p>';
					} else{
						echo '<p>You are a standard user.</p>';
					} ?>
					
					<ul>
					<li><a href="update.php">Update details</li>
					<li><a href="changepass.php">Change password</li>
					<li><a href="logout.php">Log out</a></li>
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
