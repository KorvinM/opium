<?php
/*
 * functions.php
 * 
 
 */

/*sanitize
 * escape function
 * uses htmlentities which  Converts all applicable characters to HTML entities
 */


function escape($string){
	return htmlentities($string, ENT_QUOTES, 'UTF-8');//the ENT_QUOTES flag will convert both double and single quotes.
	};
?>

