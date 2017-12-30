<?php

class Header
{

    public function __construct (){

    }

    public function __destruct(){

    }

    public static function get($attr = NULL){
        $header = array();
        foreach(headers_list() as $index => $value){
            $fields = explode(':' , $value);
            if(is_null($attr)){
                $header[$fields[0]] = $fields[1];  
            } 
            else if($fields[0] === $attr){
                return $fields[1];
            }
        }
        return $header;
    } 

    public static function set($attr, $value){
        header($attr.':'.$value);
    } 
}

?>