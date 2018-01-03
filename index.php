<?php

require_once './app/Route.php'; 

function __autoload($class_name) 
{
    include_once './app/model/'.$class_name.'.php';
}
?>
