<?php
/*
 * Hash.php
 * purely for security
 * say hashing 'password'='1234567'
 * we add a salt
 * 'password1YaaYHkTYF'= 999
 * 'password2IjgshssTY'= 555
 * 
 */
 
 class Hash{
	public static function make($string, $salt='') {//pass a string to be hashed, and optionally a salt
		return hash('sha256', $string . $salt);
	}
	
	public static function salt($length) {
		return mcrypt_create_iv($length);//return a load of nonsense, ensuring a strong enough salt
	}
	
	
	public static function unique() {
		return self::make(uniqid());
	}
	 
	 
}
 

?>
