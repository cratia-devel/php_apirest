<?php
/**
 * Class Request
 *  
 * @category Public
 * @package  Example
 * @author   Carlos A. Ratia. V <cratia@gmail.com>
 * @license  https://github.com/cratia-devel/php_apirest/blob/master/LICENSE 
 * @link     https://github.com/cratia-devel/php_apirest
 */
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
    
    private $_header;
    private $_body;
    private $_query;

    static private $_instance = null;

    /**
     * Method
     * Constructor
     */
    function __construct()
    {
        $URL_ALL = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI']);
        $this->scheme = isset($URL_ALL['scheme'])? $URL_ALL['scheme'] : null;
        $this->host = isset($URL_ALL['host'])? $URL_ALL['host'] : null;
        $this->port = isset($URL_ALL['port'])? $URL_ALL['port'] : null;
        $this->user = isset($URL_ALL['user'])? $URL_ALL['user'] : null;
        $this->pass = isset($URL_ALL['pass'])? $URL_ALL['pass'] : null;
        $this->path = isset($URL_ALL['path'])? $URL_ALL['path'] : null;
        $this->query = isset($URL_ALL['query'])? $URL_ALL['query'] : null; 
        $this->fragment = isset($URL_ALL['fragment'])? $URL_ALL['fragment'] : null;

        $this->_header = new Header(getallheaders()); 
        $this->_body = json_decode(file_get_contents('php://input'), true);
        $this->_query = array();
        parse_str($this->query, $this->_query);

        var_dump($_SERVER);
        die();

    }

    /**
     * Method
     * Retrieve a header from the request.
     * 
     * @return array
     */
    public function getHeader(): array 
    {
        return $this->_header->getHeader();
    }

    /**
     * Method
     * Retrieve a body from the request.
     * 
     * @return array
     */
    public function getBody(): array 
    {
        return $this->_body;
    }

    /**
     * Method
     * Retrieve a body from the request.
     * 
     * @return array
     */
    public function getQuery(): array 
    {
        return $this->_query;
    }

    /**
     * Method
     * Determine if the request contains a given input item key in the body.
     * 
     * @param string|array $key 
     * 
     * @return bool 
     */
    public function exists(mixed $key): bool
    {
        if (is_string($key)) {
            return array_key_exists($key, $this->_body);
        } else if (is_array($key)) {
            foreach ($key as $_ => $value) {
                if (is_string($value)) {
                    if (array_key_exists($value, $this->_body)) {
                        return true;
                    }
                }
            }
        } else {
            return false;
        }
    }

    /**
     * Method
     * Determine if the request contains a given input item key in the body.
     * 
     * @param string|array $key 
     * 
     * @return bool 
     */
    public function has(mixed $key): bool
    {
        return $this->exists($key);
    }

    /**
     * Method
     * Determine if a header is set on the request.
     * 
     * @param string $key 
     * 
     * @return bool 
     */
    public function hasHeader(string $key): bool
    {
        return array_key_exists($key, $this->getHeader());
    }

    /** 
     * Method
     * Determine if the request contains a given input item key in the body.
     * 
     * @return array 
     */
    public function keys(): array
    {
        return array_keys($this->getBody());
    }

    /** 
     * Method
     * Get all of the input for the request BODY + QUERY_STRING.
     * 
     * @param mixed|null $keys 
     * 
     * @return array 
     */
    public function all(mixed $keys = null): array
    {
        return array_merge($this->getBody(), $this->getQuery());
    }

    /**
     * Method
     * Determine if the request is sending JSON.
     * 
     * @return bool
     */
    public function isJson(): bool
    {
        if (array_keys($this->_header, 'Content-Type')) {
            if ($this->_header[''] === 'application/json') {
                return true;
            }
        }
        return false;
    } 

    /**
     * Method
     * Return the Request instance.
     * 
     * @return Request
     */
    public static function instance(): Request
    {
        if (is_null($this->_instance)) {
            $this->_instance = new Request();
        }
        return $this->_instance;
    }

    /**
     * Method
     * Get the request method.
     * 
     * @return string
     */
    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Method
     * Get the request method.
     * 
     * @return string
     */
    function isAjax() 
    {
        $band1 = isset($_SERVER['HTTP_X_REQUESTED_WITH']); 
        $band2 = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        return $band1 && $band2;
    }
}

?>