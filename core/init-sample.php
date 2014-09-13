<?php
/*
 * init.php
 * this file should be required in each file.
 * 
 */

session_start();//Start new or resume existing session http://php.net/manual/en/function.session-start.php

$GLOBALS['config'] = array(//Reference all variables available in global scope http://uk3.php.net/manual/en/reserved.variables.globals.php
	'mysql' =>array(
		'host' => 'db host here',
		'username' => 'db username here',
		'password' => 'db password here',
		'db' => 'db name here'
	),
	'remember' =>array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 66666
	),
	'session' =>array(
		'session_name' => 'user',
		'token_name' =>'token'
	)
);

spl_autoload_register( function($class) {//register the given (anonymous) function  as __autoload() implementation. http://uk3.php.net/manual/en/function.spl-autoload-register.php Loads classes http://uk3.php.net/manual/en/function.autoload.php
		require_once 'classes/' . $class . '.php';
	}
);

require_once 'functions.php';//load functions http://uk3.php.net/manual/en/function.require-once.php


/*
 * check cookie for remember and auto login
 */

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){//Remember Me is in effect	
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash','=', $hash));
	
	if($hashCheck->count()){
		//Hash matches, log user in
		$user = new User($hashCheck->first()->user_id);
		$user->login();
		
	} 
}
