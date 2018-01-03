<?php

class Header
{
    private $header;

    public function __construct(array $header = null)
    {
        if (!is_null($header)) {
            $this->header = array();
            foreach ($header as $key =>$value) {
                $this->header[$key] = $value; 
            }                
        }
        $this->header = array();
    }

    public function __destruct()
    {

    }

    public static function get($attr = null) 
    {
        $header = array();
        foreach (headers_list() as $index => $value) {
            $fields = explode(':', $value);
            if (is_null($attr)) {
                $header[$fields[0]] = $fields[1];  
            } else if ($fields[0] === $attr) {
                return $fields[1];
            }
        }
        return $header;
    } 

    public function getHeader(): array 
    {
        return $this->header;
    }

    public static function set($attr, $value)
    {
        header($attr.':'.$value);
    } 
}

?>