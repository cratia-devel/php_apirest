<?php

class Person extends Model
{
    protected $firstname;
    protected $lastname;
    protected $age;

    public function __construct() {
        parent::__construct();
        $this->table = 'person';
        $this->firstname = 'Firstname';
        $this->lastname = 'Lastname';
        $this->age = 0;
        
    }

    function __destruct() {
        parent::__destruct();
    }


}


?>