<?php
/*
 * config.php
 * config class

 */
require_once 'core/init.php';

class Config {
	public static function get($path = null){
		if ($path){
			$config = $GLOBALS['config'];
			$path = explode('/' , $path);
			
			/*loop*/
			foreach($path as $bit) {
				if (isset($config[$bit])) {
					$config = $config[$bit];
				}
			}
			
			return $config;
			
		}
	return false;	
	}
}//end class Config
?>
