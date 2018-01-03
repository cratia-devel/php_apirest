<?php
class Route
{

    public static function get($route, $function) 
    {
        $path = self::getPath($_SERVER['REQUEST_URI']);
        if ($path === $route) {
            if ($_SERVER['REQUEST_METHOD'] ==='GET') {
                $request = new Request();
                $response = new Response();
                $function->__invoke($request, $response);
            } else {
                http_response_code(405);    
            }
        }
    }

    public static function post($route, $function) 
    {
        $path = self::getPath($_SERVER['REQUEST_URI']);
        if ($path === $route) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $request = new Request();
                $response = new Response();
                $function->__invoke($request, $response);
            } else {
                http_response_code(405);    
            }
        }
    }

    private function getPath(string $route): string 
    {
        $path = explode('#', $route)[0];
        $path = explode('?', $route)[0];
        return $path;
    }
}

?>
