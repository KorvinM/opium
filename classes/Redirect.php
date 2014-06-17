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
			header('Location: ' . $location);
			exit();
		}
		
	}
	 
}
?>
