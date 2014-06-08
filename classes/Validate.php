<?php
/*
 * Validate.php

 * Time saver for quick validation
 */
 
class Validate {
	
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function __construct(){
		$this->_db = DB::getInstance();
	}
			
    public function check ($source, $items = array()) {
		foreach($items as $item => $rules){
			foreach ($rules as $rule => $rule_value) {
				//echo "{$item} {$rule} must be {$rule_value} <br> ";
				$value = trim($source[$item]);
				$item = escape($item);//sanitise raw value
				
				if ($rule === 'required' && empty ($value)){
					//houston, we have a problem
					$this->addError("{$item} is required.");
				} else if (!empty($value)){
					//ok, switch between cases and test
					switch($rule){
						case 'min';
							if(strlen($value) < $rule_value){
								$this->addError("{$item} must be over {$rule_value} characters.");
							}
						break;
						case 'max';
							if (strlen($value) > $rule_value){
								$this->addError("{$item} can't exceed {$rule_value} characters.");
							}
						
						break;
						case 'matches';
							if($value != $source[$rule_value]){
								$this->addError("{$rule_value} must match {$item}");
							}
						break;
						case 'unique';
							$check = $this->_db->get($rule_value, array($item, '=',$value));
							if ($check->count()){
								$this->addError("{$item} already exists");
								
							}
						break;
						
					}	
				}
			}
		}
		
		if(empty($this->_errors)){//now were done looping through everything, set passed to true of there are no errors
			$this->_passed = true;
		}
		return $this; //so we can chain it on later
	}
	
	private function addError($error){
		$this->_errors[] = $error;
		
		
	}
	
	public function errors(){
		return $this->_errors;
	}
	
	public function passed(){
		return $this->_passed;
	}

}
?>
