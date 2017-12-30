<?php

class Model {

    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $is_deleted;

    protected $table;
    protected $db;
    protected $db_object_state;

    private $query;
    private $parameters;

    public function __construct() {
        $this->id = -1;
        $this->is_deleted = false;
        $this->db = new Database();
        $this->db_object_state = NULL;
        $this->_clean_query();
    }

    function __destruct() {    
    }

    public function is_new() {
        return ($this->id === -1);
    }

    public function all() {
        list($this->query['where'],$this->parameters) = QueryBuilder::Builder('WHERE', $this->table, 1, '', '');
        return $this;
    }

    public function find($params) {
        if (is_int($params)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
            $parameters = array(':id' => $params);
        }
        if (is_array($params)) {
            $query = 'SELECT * FROM ' . $this->table . ' WHERE';
            $parameters = array();
            $i = 1;
            foreach ($params as $value) {
                if (is_int($value)) {
                    $query .= ' (id = :id' . $i . ')';
                    $parameters = array_merge($parameters, array(':id' . $i => $value));
                    $i++;
                    if($i <= count($params)) {
                        $query .= ' OR';
                    }
                }
            }
        }
        $this->db->query($query, $parameters);
        return $this->db->fetchAll();
    }

    private function _where($row, $conditional, $value) {
        list($this->query['where'],$this->parameters) = QueryBuilder::Builder('WHERE', $this->table, $value, $row, $conditional);
        return $this;
    }

    public function where($conditionals, $conditional = NULL, $value = NULL) {
        if (!is_null($conditional) && !is_null($value)) {
            return $this->_where($conditionals, $conditional, $value);
        }
        else if (is_array($conditionals)) {
            return $this->_where($conditionals[0], $conditionals[1], $conditionals[2]);
        }
        return $this;
    }

    public function save() {
        if ($this->is_new()) {
            return $this->_insert();
        } else if ($this->is_dirty()) {
            return $this->_update();
        } else {
            return false;
        }
    }

    public function load($id){
        $result = $this->find($id);
        if(empty($result))
            return false;
        $this->db_object_state = $result[0];
        $values_object = $this->_before_commit();
        foreach ($this->db_object_state as $key => $value) {
            $this->{$key} = $this->db_object_state[$key];
        }
        return true;
    }

    public function is_dirty() {        
        $values_object = $this->_before_commit();
        foreach ($values_object as $key => $_) {
            if( $this->db_object_state[$key] != $values_object[$key] ){
                return true;
            }
        }
        return false;
    }
    
    private function _insert() {
        $values_object = $this->_before_commit('INSERT');
        $values_object['created_at'] = date('Y-m-d H:i:s');
        list($query,$parameters) = QueryBuilder::Builder('INSERT', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();
    }

    private function _update() {
        $values_object = $this->_before_commit('UPDATE');
        $values_object['updated_at'] = date('Y-m-d H:i:s');
        list($query,$parameters) = QueryBuilder::Builder('UPDATE', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();
    }

    private function _before_commit($type_query = 'DEFAULT') {
        $values_object = get_object_vars($this);

        unset($values_object['table']);
        unset($values_object['db']);
        unset($values_object['db_object_state']);
        unset($values_object['query']);
        unset($values_object['parameters']);

        switch ($type_query) {
            case 'INSERT':
                unset($values_object['id']);
                break;
            case 'UPDATE':
                break;
            default:
                break;
        }
        return $values_object;
    }

    public function get() {
        $this->prepare_query();
        $this->db->query($this->query['query'], $this->parameters);
        $this->_clean_query();
        return $this->db->fetchAll();        
    }

    public function prepare_query() {
        $this->query['query'] = $this->query['where'].' '.$this->query['groupby'].' '.$this->query['orderby'].' '.$this->query['limit'];
        var_dump($this->query['query'],$this->parameters);
        //die();
    }

    public function limit($cant = 1, $offset = NULL ){
        if(is_int($cant)){
            $this->query['limit'] = 'LIMIT '.$cant;
        }
        if(!is_null($offset) && is_int($offset)){
            $this->query['limit'] .= ' OFFSET '.$offset;
        }
        return $this;
    }

    public function order_by($row, $order = 'ASC') {
        $this->query['orderby'] = 'ORDER BY '.$row.' '.$order;
        return $this;
    }

    public function group_by($row) {
        $this->query['groupby'] = 'GROUP BY '.$row.' ';
        return $this;
    }


    private function _clean_query (){
        $this->query               = array();
        $this->query['where']      = '';
        $this->query['groupby']    = '';
        $this->query['orderby']    = '';
        $this->query['limit']      = '';
        $this->parameters          = array();
    }
}
