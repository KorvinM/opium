<?php
/*
 * Token.php
 * generates and checks tokens to protect against cross-site request forgery
 * without this, the user could enter a query after the register url like: "?username=joe" or "name="Joe Bloggs" and enter data this way. In testing, ?password=passowrd doesn't seem to enter data even wthout this protection
 * 
 */
 
class Token {
	public static function generate() {
		return Session::put(Config::get('session/token_name'), md5(uniqid()));
		
	}

	public static function check($token){
		$tokenName = Config::get('session/token_name');
		if (Session::exists ($tokenName) && $token === Session::get($tokenName)){
			Session::delete($tokenName);
			return true;
		}
		return false;
	}
}
?>
