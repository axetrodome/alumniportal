<?php
class DB{
	private static $_instance = null; 
	private $_pdo,
			$_results,
			$_count = 0,
			$_query,
			$_total,
			$_errors = false;
	public function __construct(){
		try{
			$this->_pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/user'),Config::get('mysql/pass'));
		}catch(PDOexception $e){
			die($e->getMessage());
		}
	}
	public static function getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}
	public function query($sql,$params = array()){
		$this->_errors = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			if($params !== null){
				$x = 1;	
				foreach ($params as $param) {
					$this->_query->bindValue($x,$param);
					$x++;
				}
			}
			if($this->_query->execute()){
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				$this->_total = $this->_pdo->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
			}else{
				$this->_errors = true;
			}
		}
		return $this;
	}
	public function action($action,$table,$where = array()){
		if(count($where == 3)){
			$operators = array('=','>=','<=','<','>');
			$field = $where[0];
			$operator = $where[1];
			$values = $where[2];
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				 return $this->query($sql,array($values));
				// if(!$this->query($sql,array($values))->errors()){
				// 	return $this;
				// }
			}else if($where == null){
				$sql = "{$action} FROM {$table}";
				return $this->query($sql,null);
			}
		}
		return false;
	}
	public function insert($table,$fields = array()){
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			foreach ($fields as $field) {
				$values .= '?';
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++; 
			}
			$sql = "INSERT INTO {$table} (`".implode('`,`',$keys)."`) VALUES ({$values})";
			if(!$this->query($sql,$fields)->errors()){
				return true;
			}
		return false;
	}
	//pagination
	public function pagination($action,$table,$limit = array()){
		if($limit !== null){
			$start = $limit[0];
			$perPage = $limit[1];
			$sql = "{$action} FROM {$table} ORDER BY id DESC LIMIT {$start},{$perPage}";
			return $this->query($sql,null);
		}else{
			$sql = "{$action} FROM {$table}";
			return $this->query($sql,null);
		}
		return false;
	}
	//total pages count
	public function total(){
		return $this->_total;
	}
	//getting posts limit
	public function limit($table,$where = array(),$limit){
		$operators = array('=','>=','<=','<','>');
		$field = $where[0];
		$operator = $where[1];
		$values = $where[2];
		if(in_array($operator, $operators)){
			$sql = "SELECT * FROM {$table} WHERE {$field} {$operator} ? ORDER BY id DESC LIMIT {$limit}";
			 return $this->query($sql,array($values));
		}
		return false;
	}
	public function page($table,$limit = array()){
		if($limit != null){
			return $this->pagination('SELECT SQL_CALC_FOUND_ROWS *',$table,$limit);
		}else{
			return $this->pagination('SELECT SQL_CALC_FOUND_ROWS *',$table,null);
		}
	}
	public function get($table,$where = array()){
		if($where == null){
			return $this->action('SELECT *',$table,null);
		}else{
			return $this->action('SELECT *',$table,$where);
		}
	}
	public function update($table,$id,$fields = array()){
		$set = '';
		$x = 1;
		foreach($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .=', ';
			}
			$x++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if(!$this->query($sql,$fields)->errors()){
			return true;
		}
		return false;	
	}
	// adding total values
	public function delete($table,$where = array()){
		return $this->query('DELETE',$table,$where);
	}
	public function errors(){
		return $this->_errors;
	}
	public function count(){
		return $this->_count;
	}
	public function results(){
		return $this->_results;
	}
	public function first(){
		return $this->results()[0];
	}
}

