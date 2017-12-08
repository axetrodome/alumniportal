<?php 
class Validation{
	private $_db = null,
			$_errors = array(),
			$_passed = false;
	public function __construct(){
		//remember don't ever ever everv mispell any single shits inside the construct
		$this->_db = DB::getInstance();
	}
	public function check($source,$items = array()){
		foreach ($items as $item => $rules) {
			$value = trim($source[$item]);
			$item = escape($item);
			foreach ($rules as $rule => $rule_value) {
				if($rule === 'required' && empty($value)){
					$this->addErrors("{$item} is required");
				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addErrors("{$item} must be minimum of {$rule_value}");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addErrors("{$item} must be maximum of {$rule_value}");
							}
							break;
						case 'matches':
							if($value != $source[$rule_value]){
								$this->addErrors("{$item} must match of {$rule_value}");
							}
							break;
						case 'unique':
							$check = $this->_db->get($rule_value,array($item,'=',$value));
							if($check->count()){
								$this->addErrors("{$item} is already exists");
							}
							break;													
					}
				}
			}
		}
		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this; //method chaining
	}
	public function addErrors($errors){
		$this->_errors[] = $errors;
	}
	public function errors(){
		return str_replace('_',' ',$this->_errors);
	}
	public function passed(){
		return $this->_passed;
	}
}