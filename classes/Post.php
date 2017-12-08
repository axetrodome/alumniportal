<?php
class Post{
	private $_db,
			$_isAdmin,
			$_postResults;

	public function __construct($post = null){
       	$this->_db = DB::getInstance();
	}
	//optional
	public function selectAll($table,$fields = array()){
        if($fields == null){
        	$data = $this->_db->get($table,null);
           	return $this->_postResults = $data->results();
        }else{
        	$data = $this->_db->get($table,$fields);
        	return $this->_postResults = $data->results();
        }
        return false;
	}
	public function create($fields = array()){
		if(!$this->_db->insert('posts',$fields)){
			throw new exception('error while creating posts');
		}
	}
	public function update($fields = array(), $id = null){
		if(!$this->_db->update('posts',$id,$fields)){
			throw new exception('error while updating');
		}
	}
	public function limit($where = array(),$limit){
		if(!$this->_db->limit('posts',$where,$limit)){
			throw new Exception("Error Processing Request");
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
		return $this->_db->results();
	}
	public function exists(){
		return (!empty($this->_postResults)) ? true : false;
	}
}	