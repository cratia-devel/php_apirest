<?php

function get_vars($object) {
    var_dump($object);
    return get_class_vars(get_class($object));
}

function get_values($object) {
    return get_object_vars($object);
}

class Model
{
    
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $is_deleted;

    protected $table;
    protected $db;

    public function __construct() {
        $this->id = -1;
        $this->is_deleted = false;
        $this->db = new Database();
    }

    function __destruct() {

    }

    public function is_new() {
        return ($this->id === -1);
    }

    public function all() {
        if($this->db->hasError())
            return NULL;
        $this->db->query('SELECT * FROM '.$this->table);
        return $this->db->fetchAll();
    } 
    
    public function find($params) {
        if(is_int($params)) {
            $query = 'SELECT * FROM '.$this->table.' WHERE id = :id';
            $parameters = array(':id' => $params);
        }
        if(is_array($params)){
            $query = 'SELECT * FROM '.$this->table.' WHERE';
            $parameters = array();
            $i = 1;
            foreach($params as $value){
                if(is_int($value)) {
                    $query .= ' (id = :id'.$i.')';
                    $parameters= array_merge($parameters, array(':id'.$i => $value));
                    $i++;
                    if($i <= count($params)){
                        $query .= ' OR';
                    }
                }    
            }
        }
        $this->db->query($query, $parameters);
        return $this->db->fetchAll();
    }

    private function _where($row, $conditional, $value) {
        $query = 'SELECT * FROM '.$this->table.' WHERE '.$row.' '.$conditional.' :value';
        $this->db->query($query, array(':value' => $value));
        return $this->db->fetchAll();
    }

    public function where($conditionals, $conditional = NULL, $value = NULL) {
        if(!is_null($conditional) && !is_null($value))
            return $this->_where($conditionals,$conditional,$value);
        if(is_array($conditionals)){
            $data = array();
            foreach($conditionals as $array){
                if(is_array($array))
                    $data = array_merge($data, $this->_where($array[0],$array[1],$array[2]));
                else
                    return $this->_where($conditionals[0],$conditionals[1],$conditionals[2]);
            }
            return $data;
        }
        return NULL;
    }
    public function save() {
        if($this->is_new())
            return $this->_insert();
        else if($this->is_dirty()) 
            return $this->_update();
        else
            return false;
    }

    private function _insert() {

        $vars_object  = get_class_vars(get_class($this));
        $values_object = get_object_vars($this);
        $values_object['created_at'] = date('Y-m-d H:i:s'); 

        unset($vars_object['id']);
        unset($vars_object['table']);
        unset($vars_object['db']);
    
        $query = 'INSERT INTO '.$this->table.'';
        $sub_query1 = '( ';
        $sub_query2 = '( ';
        $parameters = array();
        $i = 1;

        foreach ($vars_object as $key => $value) {
            $sub_query1 .=  $key;
            $sub_query2 .= ':value'.$i;
            if($i < count($vars_object)){
                $sub_query1 .= ' , ';
                $sub_query2 .= ' , ';
            }
            $parameters = array_merge($parameters, array(':value'.$i => $values_object[$key]));
            $i++;
        }
        $sub_query1 .= ' )';
        $sub_query2 .= ' )';
        $query = $query.' '.$sub_query1.' VALUES '.$sub_query2;
        $this->db->query($query, $parameters);
        return $this->db->commit();     
    }

    private function _update() {
        $query = 'UPDATE INTO person (id, firstname, lastname, age) VALUES (:value1, :value2, :value3, :value4)';
    }
}

?>