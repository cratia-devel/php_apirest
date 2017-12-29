<?php

class Person extends Model
{
    public $firstname;
    public $lastname;
    public $age;

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