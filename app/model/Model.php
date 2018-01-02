<?php
class Model 
{
    protected $id;
    protected $created_at;
    protected $updated_at;
    protected $deleted_at;
    protected $is_deleted;

    protected $table;
    protected $db;
    protected $db_object_state;

    private $_query;
    private $_parameters;

    public function __construct() 
    {
        $this->id = -1;
        $this->is_deleted = false;
        $this->db = new Database();
        $this->db_object_state = null;
        $this->_cleanQuery();
    }

    public function __destruct() 
    {    
    }

    public function isNew() 
    {
        return ($this->id === -1);
    }

    public function all() 
    {
        list($this->_query['where'],$this->_parameters) = QueryBuilder::Builder('WHERE', $this->table, 1, '', '');
        return $this;
    }

    public function find($params) 
    {
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
                    if ($i <= count($params)) {
                        $query .= ' OR';
                    }
                }
            }
        }
        $this->db->query($query, $parameters);
        return $this->db->fetchAll();
    }

    private function _where($row, $conditional, $value) 
    {
        list($this->_query['where'],$this->_parameters) = QueryBuilder::Builder('WHERE', $this->table, $value, $row, $conditional);
        return $this;
    }

    public function where($conditionals, $conditional = null, $value = null) 
    {
        if (!is_null($conditional) && !is_null($value)) {
            return $this->_where($conditionals, $conditional, $value);
        } else if (is_array($conditionals)) {
            return $this->_where($conditionals[0], $conditionals[1], $conditionals[2]);
        }
        return $this;
    }

    public function save() 
    {
        if ($this->isNew()) {
            return $this->_insert();
        } else if ($this->isDirty()) {
            return $this->_update();
        } else {
            return false;
        }
    }

    public function load($id)
    {
        $result = $this->find($id);
        if (empty($result)) {
            return false;
        }
        $this->db_object_state = $result[0];
        $values_object = $this->_beforeCommit();
        foreach ($this->db_object_state as $key => $value) {
            $this->{$key} = $this->db_object_state[$key];
        }
        return true;
    }

    public function isDirty() 
    {        
        $values_object = $this->_beforeCommit();
        foreach ($values_object as $key => $_) {
            if ($this->db_object_state[$key] != $values_object[$key]) {
                return true;
            }
        }
        return false;
    }
    
    private function _insert() 
    {
        $values_object = $this->_beforeCommit('INSERT');
        $values_object['created_at'] = date('Y-m-d H:i:s');
        list($query,$parameters) = QueryBuilder::Builder('INSERT', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();
    }

    private function _update() 
    {
        $values_object = $this->_beforeCommit('UPDATE');
        $values_object['updated_at'] = date('Y-m-d H:i:s');
        list($query,$parameters) = QueryBuilder::Builder('UPDATE', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();
    }

    private function _beforeCommit($type_query = 'DEFAULT')
    {
        $this->db->query('DESCRIBE '.$this->table);
        $describe = $this->db->fetchAll();
        foreach ($describe as $index => $value) {
            $rows[$value['Field']] = '';
        }
        $values_object = get_object_vars($this);
        foreach ($values_object as $key => $value) {
            if (array_key_exists($key, $rows)) {
                $rows[$key] = $value;
            }
        }
        switch ($type_query) {
            case 'INSERT':
                unset($rows['id']);
                break;
            case 'UPDATE':
                break;
            default:
                break;
        }
        return $rows;
    }

    public function delete($id = null) 
    {
        if (is_null($id)) {
            $this->load($this->id);
        } else {
            $this->load($id);    
        }
        $values_object = $this->_beforeCommit('UPDATE');
        $values_object['deleted_at'] = date('Y-m-d H:i:s');
        $values_object['is_deleted'] = true; 
        list($query,$parameters) = QueryBuilder::Builder('UPDATE', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();        
    }

    public function hardDelete($id = null)
    {
        if (is_null($id)) {
            $this->load($this->id);
        } else {
            $this->load($id);    
        }
        list($query,$parameters) = QueryBuilder::Builder('DELETE', $this->table, array('id' => $id));
        $this->db->query($query, $parameters);
        return $this->db->commit();   
    }

    public function trash()
    {
        return $this->_where('is_deleted', '=', true);   
    }

    public function remove($id = null) 
    {
        if (is_null($id)) {
            $this->load($this->id);
        } else {
            $this->load($id);    
        }
        $this->load($id);
        $values_object = $this->_beforeCommit('UPDATE');
        $values_object['deleted_at'] = date('Y-m-d H:i:s');
        $values_object['is_deleted'] = true; 
        list($query,$parameters) = QueryBuilder::Builder('UPDATE', $this->table, $values_object);
        $this->db->query($query, $parameters);
        return $this->db->commit();
    }

    public function get() 
    {
        $this->prepareQuery();
        $this->db->query($this->_query['query'], $this->_parameters);
        $this->_cleanQuery();
        return $this->db->fetchAll();        
    }

    public function prepareQuery() 
    {
        $this->_query['query'] = $this->_query['where'].' '.$this->_query['groupby'].' '.$this->_query['orderby'].' '.$this->_query['limit'];
    }

    public function limit($cant = 1, $offset = null )
    {
        if (is_int($cant)) {
            $this->_query['limit'] = 'LIMIT '.$cant;
        }
        if (!is_null($offset) && is_int($offset)) {
            $this->_query['limit'] .= ' OFFSET '.$offset;
        }
        return $this;
    }

    public function orderBy($row, $order = 'ASC') 
    {
        $this->_query['orderby'] = 'ORDER BY '.$row.' '.$order;
        return $this;
    }

    public function groupBy($row) 
    {
        $this->_query['groupby'] = 'GROUP BY '.$row.' ';
        return $this;
    }

    private function _cleanQuery()
    {
        $this->_query               = array();
        $this->_query['where']      = '';
        $this->_query['groupby']    = '';
        $this->_query['orderby']    = '';
        $this->_query['limit']      = '';
        $this->_parameters          = array();
    }
}