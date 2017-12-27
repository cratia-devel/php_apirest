<?php

class Request
{
    public $scheme;
    public $host;
    public $port;
    public $user;
    public $pass;
    public $path;
    public $query; 
    public $fragment;

    function __construct()
    {
        $URL_ALL = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']);
        $this->scheme = isset($URL_ALL['scheme'])? $URL_ALL['scheme'] : NULL;
        $this->host = isset($URL_ALL['host'])? $URL_ALL['host'] : NULL;
        $this->port = isset($URL_ALL['port'])? $URL_ALL['port'] : NULL;
        $this->user = isset($URL_ALL['user'])? $URL_ALL['user'] : NULL;
        $this->pass = isset($URL_ALL['pass'])? $URL_ALL['pass'] : NULL;
        $this->path = isset($URL_ALL['path'])? $URL_ALL['path'] : NULL;
        $this->query = isset($URL_ALL['query'])? $URL_ALL['query'] : NULL; 
        $this->fragment = isset($URL_ALL['fragment'])? $URL_ALL['fragment'] : NULL;

    }
}

?>