<?php
/*
 * Redirect.php
 * Takes care of redirects using status codes or to any specific uri
 * header(); //sends a raw HTTP header - http://uk3.php.net/manual/en/function.header.php
 * Usage
 * Redirect::to(404);
 * Redirect::to('index.php');
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
