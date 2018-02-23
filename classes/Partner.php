<?php
class Partner {
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_results,
            $_loggedIn = false;

    public function __construct($user = null){
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/partner_session');
        $this->_cookieName  = Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);  //Get the currently logged-in user id
                if($this->find($user)){
                    $this->_loggedIn = true;
                }else{
                    //process logout
                }
            }
        }else{
            $this->find($user);
        }
    }
    public function get($fields = array()){
        $data = $this->_db->get('partners',$fields);
        $this->_results = $data->results();
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
        return $this->_results;
    }
    public function DBresults(){
        return $this->_db->results();
    }
    public function create($fields = array()){
        if(!$this->_db->insert('partners', $fields)){
            throw new Exception('Three was a problem creating an account');
        }
    }

    public function update($fields = array(), $id = null){
        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }

        if(!$this->_db->update('partners', $id, $fields)){
            throw new Exception('There was a problem updating.');
        }
    }

    // find and set partners data to _data
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->_db->get('partners', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }

        return false;
    }

    public function login($email = null, $password = null, $remember = false){

        if(!$email && !$password && $this->exists()){
            Session::put($this->_sessionName, $this->data()->id);
            $this->_loggedIn = true;
        }else {
            $user = $this->find($email);
            if ($user) {
                //check if password matched
                if ($this->data()->password == Hash::make($password, $this->data()->salt)) {
                    //check if the user is already accepted by the admin
                    Session::put($this->_sessionName, $this->data()->id);
                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        //set cookie
                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }
    public function delete($fields = array()){
        if(!$this->_db->delete('partners',$fields)){
            throw new Exception('There was a problem while deleting.');
        }
    }
    public function data(){
        return $this->_data;
    }
    public function isLoggedIn(){
        return $this->_loggedIn;
    }

    public function logout(){

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function exists(){
        return (!empty($this->_data)) ? true : false;
    }

    public function hasPermission($key){
        $group = $this->_db->get('groups', array('id', '=', $this->data()->groups));
        if($group->count()){
            $permissions = json_decode($group->first()->permission, true);

            if(isset($permissions[$key])){
                if($permissions[$key] == 1){
                    return true;
                }
            }
        }
        return false;
    }

} 