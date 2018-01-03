<?php

class Response
{
    private $header;
    private $messaje    = array(
        'data'  => array(),
        'error' => array()
    );

    public function __construct()
    {
        $this->header = new Header();
    }

    public function status($http_code = 200)
    {
        if(is_int($http_code) && isset($http_code)) {
            http_response_code($http_code);
            $this->header::set('Status', $http_code);    
            return $this;
        }
        else{
            http_response_code(404);
            return $this;
        }
    }

    public function type($type = 'json') 
    {
        if($type === 'text') {
            $this->header::set('Content-Type', 'text/plain, text/html, text/css, text/javascript; charset=utf-8');
        } else if($type === 'json') {
            $this->header::set('Content-Type', 'application/json; charset=utf-8');
        } else if ($type === 'html') {
            $this->header::set('Content-Type', 'text/html; charset=utf-8');
        } else {
            $this->header::set('Content-Type', 'text/plain, text/html, text/css, text/javascript; charset=utf-8');
        }    
        return $this;
    }

    public function get($attr= null) 
    {
        return $this->header::get($attr);
    }

    public function set($attr, $value) 
    {
        $this->header::set($key, $value);
        return $this;
    }

    public function json($_data = null, $_error = null) 
    {
        $this->message = array(
            'data'  => is_null($_data) ?     array() : $_data,
            'error' => is_null($_error)?     array() : $_error
        );
        print_r(json_encode($this->message));
    }

    public function redirect($path,$status = null) 
    {
        header('Location: ' . $path, true, is_null($status) ? 302 : $status);
        exit();
    }
}

?>
