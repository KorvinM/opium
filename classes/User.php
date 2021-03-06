<?php
/*
 * User.php
 * user actions: login, register, update, delete, check if user exists, work with user profiles 

 */

class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;
	
	public function __construct($user=null) {
		$this->_db = DB::getInstance();//set the private property to make use of the database
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);
				
				if($this->find($user)){
					$this->_isLoggedIn=true;
				} else{
					//process logout
				} 
				
			}
			
		} else{
			$this->find($user);
		}
		
		
	}//end __construct
	
	public function create($fields=array()){
		if(!$this->_db->insert('users',$fields)){
			throw new Exception('There was a problem creating an account');
		}
		//assume everything has worked
	}
	
	public function update($fields = array(), $id = null){
		
		if(!$id && $this->isLoggedIn()){
			$id = $this->data()->id;//use the current users id if no id defined
		}
		if(!$this->_db->update('users', $id, $fields)){
			throw new Exception('There was a problem updating the database');
		}
	}
	
	public function find($user=null){
		if($user){
			$field = (is_numeric($user)) ? 'id':'username';//this idea will fail if the username is numeric, currently allowed! 
			$data = $this->_db->get('users', array($field, "=", $user));
			
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function login($username=null,$password=null, $remember=false){ 
		if(!$user && !$password && $this->exists()){
			//log user in
			Session::put($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			if($user) {
				if($this->data()->password === Hash::make($password,$this->data()->salt)){//'Passwords match!'
					Session::put($this->_sessionName, $this->data()->id);
					/* remember
					 * 
					 */
					if($remember){
						//generate a hash
						$hash = Hash::unique();
						//check the hash isn't already in the db
						$hashCheck = $this->_db->get('users_session',array('user_id', '=', $this->data()->id));
						
						if(!$hashCheck->count()){//insert hash into db
							$this->_db->insert('users_session', array(
								'user_id'=>$this->data()->id,
								'hash' => $hash
							));
						} else{
							$hash = $hashCheck->first()->hash;
						}
						//store a cookie
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					} 
					
					return true;
				
				}
				
			}
		
		}
		return false;
	}
	
	public function hasPermission($key){
		$group = $this->_db->get('groups', array('id', '=', $this->data()->group));
		//print_r($group->first());
		if($group->count()){
			//extract permissions
			$permissions = json_decode($group->first()->permissions,true);//decode JSON object using PHP's JSON decoder, setting the __ param to true to return an array
			//print_r($permissions);
			if($permissions[$key]== true){
				return true;
			}
		}
		return false;
	}
	
	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}
	
	public function logout(){
		$this->_db->delete('users_session', array('user_id','=',$this->data()->id));//delete hash from db
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data(){
		return $this->_data;
	}
	
	public function isLoggedIn(){
		//can include other functionality here if desired
		return $this->_isLoggedIn;
	}
}
?>
