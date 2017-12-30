<?php

class Response 
{
    private $header     = array();
    private $messaje    = array(
        'data'  => array(),
        'error' => array()
    );

    public function json($http_code = 404, $_data = NULL, $_error = NULL) {
        header('Content-Type: application/json');
        http_response_code($http_code);
        $this->message = array(
            'data'  => is_null($_data) ?     array() : $_data,
            'error' => is_null($_error)?     array() : $_error
        );
        print_r(json_encode($this->message));
    }
}

?>