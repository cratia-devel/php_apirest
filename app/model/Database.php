<?php

class Database
{
    
    private $host           = 'localhost';
    private $port           = '3306';  
    private $username       = 'root';
    private $password       = '';
    private $dbname         = 'sistema1';

    private $dns;
    private $pdo;
    private $stmt;
    private $options;
    private $error;

    private $_hasError        = false;

    public function __construct() 
    {
        $this->dns = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $this->options = array(
            PDO::ATTR_PERSISTENT        => true,
            PDO::ATTR_ERRMODE           => true,
            PDO::ERRMODE_WARNING        => true,
            PDO::ERRMODE_EXCEPTION      => true
        );
        try {
            $this->pdo = new PDO($this->dns, $this->username, $this->password, $this->options);
        } catch (PDOException $err) {
            $this->_hasError = true;
            $this->error = $err->getMessage();
        }
    }

    public function hasError() 
    {
        return $this->_hasError;
    }

    public function query($query, $parameters = null) 
    {
        $this->stmt = $this->pdo->prepare($query);
        if(!is_null($parameters)) {
            $this->bindParams($parameters);
        }
    }

    private function execute() 
    {
        $this->stmt->execute();
    }

    public function fetchAll() 
    {
        $this->execute();
        $this->stmt->setFetchMode(PDO::FETCH_ASSOC);;
        return $this->stmt->fetchAll(); 
    }

    public function bindParam($parameter, $variable, $data_type = null) 
    {
        if(is_null($data_type)) {
            switch(true){
            case is_null($variable):
                $data_type = PDO::PARAM_NULL;
                break;
            case is_bool($variable):
                $data_type = PDO::PARAM_BOOL;
                break;
            case is_int($variable):
                $data_type = PDO::PARAM_INT;
                break;
            case is_string($variable):
                $data_type = PDO::PARAM_STR;
                break;
            default:
                $data_type = PDO::PARAM_STR;
                $variable = strval($variable);
                break;    
            }
        }
        return $this->stmt->bindParam($parameter, $variable, $data_type); 
    }

    public function bindParams($parameters) 
    {
        foreach($parameters as $key => $value) {
            $this->bindParam($key, $value);
        }
    }

    public function getError() 
    {
        return $this->error;
    }

    public function commit()
    {
        return $this->stmt->execute();
    }
}

?>
