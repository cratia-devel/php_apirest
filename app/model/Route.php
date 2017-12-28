<?php
class Route
{

    public function __construct()
    {

    }

    public static function get($route, $function) 
    {
        if($_SERVER['REQUEST_URI'] == $route) {
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $request = new Request();
                $response = new Response();
                $function->__invoke($request,$response);
            }
            else {
                http_response_code(405);    
            }
        }
        else {
            http_response_code(404);
        }
    }

    public static function post($route, $function) 
    {
        if($_SERVER['REQUEST_URI'] == $route) {
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $request = new Request();
                $response = new Response();
                $function->__invoke($request,$response);
            }
            else {
                http_response_code(405);    
            }
        }
        else {
            http_response_code(404);
        }
    }
}

?>
