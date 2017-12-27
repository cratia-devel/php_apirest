<?php

require_once('./app/Route.php'); 

    function __autoload($class_name) {
        require_once './app/model/'.$class_name.'.php';
    }
?>