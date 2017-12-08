<?php
class Answer{
	private $_db,
			$results;

	public function __construct(){
		$this->_db = DB::getInstance();
	}
	public function selectAll($table,$fields = array()){
        if($fields == null){
        	$data = $this->_db->get($table,null);
           	return $this->results = $data->results();
        }else{
        	$data = $this->_db->get($table,$fields);
        	return $this->results = $data->results();
        }
        return false;
	}
	public function create($table,$fields = array()){
		if(!$this->_db->insert($table,$fields)){
			throw new exception('error while creating questions');
		}
	}
	public function update($fields = array(), $id = null){
		if(!$this->_db->update('questions',$id,$fields)){
			throw new exception('error while updating');
		}
	}
	public function page($table,$limit = array()){
		if($limit != null){
			return $this->_db->page($table,$limit);
		}else{
			return $this->_db->page($table,null);
		}
		return false;
	}
	public function total(){
		return $this->_db->total();
	}
	public function results(){
		return $this->results;
	}
}