<?php
/*
 * DB.php
 * database wrapper
 * used the PDO class http://uk3.php.net/manual/en/class.pdo.php
 */
class DB{
	private static $_instance = null;//_ is notation to denote a private or protected property of the class
	
	private $_pdo,
			$_query,
			$_error = false,
			$_results,//stores results set
			$_count = 0;
			
	private function __construct(){
		
			try {
				$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
				//'Connected';
			} catch(PDOException $e){
				die($e->getMessage());
			  }
			  
	}//end constructor
	
	public static function getInstance(){//available outside the class
			if(!isset(self::$_instance)){//if database is not instantiated
				self::$_instance = new DB();//instantiate; will run contructor above
			}
			return self::$_instance;//if $_instance has already been set, just return existing instance
	}
	
	public function query($sql, $params = array()){
		$this->_error = false;//reset error to false, in case there's one from a previous query
		if($this->_query=$this->_pdo->prepare($sql)){//prepare & test, bind params & execute
	    //'Query prepared successfully';
			$pos = 1;
			if (count($params)){//check parameters exist and bind
				foreach($params as $param){
					$this->_query->bindValue($pos,$param);
					$pos++;
				}
			}
			//we still execute with no params
			if($this->_query->execute()){//execute and test
				//'Query successfully executed';
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);//store results as a PDO object
				$this->_count = $this->_query->rowCount();// count te number of results http://uk3.php.net/manual/en/pdostatement.rowcount.php
			} else{
				$this->_error = true;
			}	
			
		}//end prepare and execute query
		return $this;//return object to be availabe
	}//end func query
	
	public function action($action,$table,$where = array() ){
		if (count($where) ===3){//3 because we need field, operator and value
			$operators = array('=','>','<','>=','<=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];
			if (in_array($operator,$operators)){
				
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";//for example, $sql = "SELECT * FROM users WHERE username = 'jon'. Jon is the value bound to the '?'
				if (!$this->query($sql, array($value))->error()){
					return $this;
				}
			}
		}
		return false;
	}
	
	public function get($table,$where){
		return $this->action('SELECT *', $table, $where);//grab everything from the table
	}
	
	public function delete($table,$where){
		return $this->action('DELETE *', $table, $where);
	}
	
	public function insert($table, $fields = array()){
		if (count($fields)){
			/*
			 * init some basic variables
			 */
			$keys = array_keys($fields);//Return all the keys or a subset of the keys of an array - http://uk3.php.net/manual/en/function.array-keys.php
			$values = null;
			$x=1;
			/*
			 */
			foreach($fields as $field){
				$values .= '?';
				if( $x <  count($fields) ){
					$values .= ', ';
				}
				$x++;
			}
			//die($values);
			$sql = "INSERT INTO users (`". implode('`, `',$keys) ."`) VALUES({$values})" ;
			if(!$this->query($sql,$fields)->error()){
				return true;
			}
			echo $sql;
			
		}
		return false;
	}
	
	public function update($table, $id, $fields){
		$set='';
		$x=1;
		foreach($fields as $name => $value){
			$set .= "{$name} = ?";
			if( $x <  count($fields) ){
					$set .= ', ';
				}
				$x++;
				
		}
		;
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}" ;
		if(!$this->query($sql,$fields)->error()){
				return true;
			}
		return false;
		echo $sql;
	}
	
	public function results(){
		return $this->_results;
	}
	
	/*this function doesn't seem to work with the version of php running on the test server 
	 * 
	 public function first(){
		return $this->results()[0];
	}
	* 
	*/
	public function first(){
	    $data = $this->results();//we can get round this by assigning the results to a variable.
        return $data[0];
	}
	 
	public function error(){
		return $this->_error;
	}//end func error
			
	public function count(){
		return $this->_count;
	}
	
}//end class DB
?>
