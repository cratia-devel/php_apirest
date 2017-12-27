<?php
class Route
{

    public static function get($route, $function) 
    {
        self::getParams($route);
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
                $function->__invoke(self::$request,self::$response);
            }
            else {
                http_response_code(405);    
            }
        }
        else {
            http_response_code(404);
        }
    }

    public function getParams($route) 
    {
        var_dump($route);
    }
}

?>
