<?php
/*
 * Redirect.php
 * Deals with 404 errors or redirects to a specific pahe,
 * will abstract the header and Redirect functions  in php
 * header('Location:index.php'); //sends a raw HTTP header - http://uk3.php.net/manual/en/function.header.php
 * or
 * Redirect::to(404); //
 */
 
 class Redirect{
	public static function to($location=null){
		if($location){
			if(is_numeric($location)) {
				switch($location){
					case 404;
						header('HTTP/1.0 404 Not Found');
						include 'includes/404.php';
						exit();
					break;
					//other numerical errors can be passed to location and given cases here
					
				}
			}
			header('Location: ' . $location);
			exit();
		}
		
	}
	 
}
?>
