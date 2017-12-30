<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class Person extends Model
{
    public $firstname;
    public $lastname;
    public $age;

    public function __construct() {
        parent::__construct();
        $this->table = 'person';
        $this->firstname = generateRandomString();
        $this->lastname = generateRandomString();
        $this->age = rand(10,100);
        
    }

    function __destruct() {
        parent::__destruct();
    }


}


?>