<?php
class DBManager
{
    private $selectables = array();
    private $table;
    private $whereClause;
    private $limit;

    public function select() {
        $this->selectables = func_get_args();
        return $this;
    }

    public function from($table) {
        $this->table = $table;
        return $this;
    }

    public function where($where) {
        $this->whereClause = $where;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function result() {
        $query[] = "SELECT";
        // if the selectables array is empty, select all
        if (empty($this->selectables)) {
            $query[] = "*";  
        }
        // else select according to selectables
        else {
            $query[] = join(', ', $this->selectables);
        }

        $query[] = "FROM";
        $query[] = $this->table;

        if (!empty($this->whereClause)) {
            $query[] = "WHERE";
            $query[] = $this->whereClause;
        }

        if (!empty($this->limit)) {
            $query[] = "LIMIT";
            $query[] = $this->limit;
        }

        return join(' ', $query);
    }
}

// Now to use the class and see how METHOD CHAINING works
// let us instantiate the class DBManager
$testOne = new DBManager();
$testOne->select()->from('users');
echo $testOne->result(),'<br>';
// OR
echo $testOne->select()->from('users')->result(),'<br>';
// both displays: 'SELECT * FROM users'

$testTwo = new DBManager();
$testTwo->select()->from('posts')->where('id > 200')->limit(10);
echo $testTwo->result(),'<br>';
// this displays: 'SELECT * FROM posts WHERE id > 200 LIMIT 10'

$testThree = new DBManager();
$testThree->select(
    'firstname',
    'email',
    'country',
    'city'
)->from('users')->where('id = 2399');
echo $testThree->result(),'<br>' ;
// this will display:
// 'SELECT firstname, email, country, city FROM users WHERE id = 2399'

?>