<?php
/*
 * config.php
 * config class

 */

class Config {
	public static function get($path = null){
		if ($path){
			$config = $GLOBALS['config'];
			$path = explode('/' , $path);

			/*loop*/
			foreach($path as $bit) {
				if (isset($config[$bit])) {//Determine the variables are set and are not NULL http://uk3.php.net/manual/en/function.isset.php
					$config = $config[$bit];//set $config to the bit that we want
				} else {
					return false; //https://youtu.be/S6vDgLwJ7n8?t=424
				}
			}

			return $config;

		}
	return false;
	}


		public function __debugInfo(){

			return NULL;
		}
}//end class Config
?>
