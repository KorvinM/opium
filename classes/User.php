<?php
/*
 * User.php
 * user actions: login, register, update, delete, check if user exists, work with user profiles 

 */

class User{
	private $_db;
	
	public function __construct($user=null) {
		$this->_db = DB::getInstance();//set the private property to make use of the database
		
		
	}
	
	public function create($fields=array()){
		if(!$this->_db->insert('users',$fields)){
			throw new Exception('There was a problem creating an account');
		}
		//assume everything has worked
	}
	
	
}
?>
