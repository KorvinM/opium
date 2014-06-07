<?php
/*
 * DB.php
 */
class DB{
	private static $_instance = null;
	
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$_count = 0;
			
	private function __construct(){
		
			try {
				$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
				echo 'Connected';
			} catch(PDOException $e){
				die($e->getMessage());
			  }
			  
	}//end constructor
	
	public static function getInstance(){//available outside the class
			if(!isset(self::$_instance)){
				self::$_instance = new DB();
			}
			return self::$_instance;
	}
	
	public function query($sql, $params = array()){
		$this->_error = false;//reset error to false in case
		if($this->_query=$this->_pdo->prepare($sql)){//prepare & test, bind params & execute
			echo 'Query prepared successfully';
			$pos = 1;
			if (count($params)){//check parameters exist and bind
				foreach($params as $param){
					$this->_query->bindValue($pos,$param);
					$pos++;
				}
			}
			//we still execute with no params
			if($this->_query->execute()){//execute and test
				echo 'Query successfully executed';
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);//store results
				$this->_count = $this->_query->rowCount();//update count
			} else{
				$this->_error = true;
			}	
			
		}//end prepare and execute query
		return $this;//return object to be availabe
	}//end func query
	
	public function action($action,$table,$where = array() ){
		if (count($where) ===3){
			$operators = array('=','>','<','>=','<=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			if (in_array($operator,$operators)){
				//$sql = "SELECT * FROM users WHERE username = 'jon';
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function get($table,$where){
		return $this->action('SELECT *', $table, $where);
	}
	
	public function delete($table,$where){
		return $this->action('DELETE *', $table, $where);
	}
	
	public function results(){
		return $this->_results;
	}
	/*public function first(){
		return $this->results()[0];
	}*/
	 
	public function error(){
		return $this->_error;
	}//end func error
			
	public function count(){
		return $this->_count;
	}
	
}//end class DB
?>
