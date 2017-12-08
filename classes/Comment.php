<?php 
class Comment{
	public $_db,
			$_results,
			$_pending,
			$_isapproved;

	public function __construct(){
		$this->_db = DB::getInstance();
	}
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
		if(!$this->_db->insert('comments',$fields)){
			throw new exception('there was a problem while inserting');
		}
	}
	public function update($fields = array(),$id){
		if(!$this->_db->update('comments',$id,$fields)){
			throw new exception('there was a problem while updating');
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
	public function get($fields = array()){
		$data = $this->_db->get('comments',$fields);
		$this->_results = $data->results();
	}
	public function results(){
		return $this->_results;
	}
}