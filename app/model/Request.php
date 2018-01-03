<?php
/**
 * Request.php
 * 
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0
 * @link     https://github.com/cratia-devel/php_apirest
 */

/**
 * Class Request
 *  
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0 
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
        $URL_ALL = $_SERVER['REQUEST_SCHEME'].'://';
        $URL_ALL.= $_SERVER['SERVER_NAME'].':';
        $URL_ALL.= $_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        $URL_ALL = parse_url($URL_ALL);
        $this->scheme = isset($URL_ALL['scheme'])? $URL_ALL['scheme'] : null;
        $this->host = isset($URL_ALL['host'])? $URL_ALL['host'] : null;
        $this->port = isset($URL_ALL['port'])? $URL_ALL['port'] : null;
        $this->user = isset($URL_ALL['user'])? $URL_ALL['user'] : null;
        $this->pass = isset($URL_ALL['pass'])? $URL_ALL['pass'] : null;
        $this->path = isset($URL_ALL['path'])? $URL_ALL['path'] : null;
        $this->query = isset($URL_ALL['query'])? $URL_ALL['query'] : null; 
        $this->fragment = isset($URL_ALL['fragment'])? $URL_ALL['fragment'] : null;

        $this->_header  = new Header(getallheaders()); 
        $this->_body    = new BodyMessage();
        $this->_query   = new QueryString($this->query);
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
     * @return BodyMessage
     */
    public function body(): BodyMessage
    {
        return $this->_body;
    }

    /**
     * Method
     * Retrieve a body from the request.
     * 
     * @return QueryString
     */
    public function query(): QueryString 
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
    public function exists($key): bool
    {
        if (is_string($key)) {
            return array_key_exists($key, $this->_body->get());
        } else if (is_array($key)) {
            foreach ($key as $_ => $value) {
                if (is_string($value)) {
                    if (array_key_exists($value, $this->_body->get())) {
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
    public function has($key): bool
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
     * Determine if the request is the result of an AJAX call.
     * 
     * @return bool
     */
    function isAjax() 
    {
        $band1 = isset($_SERVER['HTTP_X_REQUESTED_WITH']); 
        $band2 = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        return $band1 && $band2;
    }

    /**
     * Method
     * Check if an input element is set on the request.
     * 
     * @param string $key ###
     * 
     * @return bool
     */
    function __isset(string $key): bool
    {

    } 

    /**
     * Method
     * Get an input element from the request. Body + QueryString
     * 
     * @param string $key #
     * 
     * @return mixed
     */
    function __get(string $key)
    {
        if (!is_null($this->_body->get($key))) {
            return $this->_body->get($key);
        } else if (!is_null($this->_query->get($key))) {
            return $this->_query->get($key);
        } else {
            return null;
        }
    } 

    /**
     * Method
     * Get an input element from the request.
     * 
     * @param string $key #
     * 
     * @return string|null
     */



}

?>
