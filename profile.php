<?php

/*
 * profile.php
 */

require_once 'core/init.php';
include('includes/header.php');
?>

<div class="main wrapper clearfix">
	<article class="grid">

		<?php
		if(!$username =Input::get('user')){
			Redirect::to('index.php');
		} else{
			$user = new User($username);
			if(!$user->exists()){
				Redirect::to(404);
			} else{
				//user exists
				$data = $user->data();
			}
			
			?>
			<h2>User Profile</h2>
			<h3><?php echo escape($data->username); ?></h3>
			<p>Full Name: <?php echo escape($data->name); ?>
			<?php
		}
?>
	</article>
</div> <!-- #main -->

<?php include('includes/footer.php');
