<?php
/**
 * QueryString.php
 * 
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0
 * @link     https://github.com/cratia-devel/php_apirest
 * PHP Version 7.2.0
 */

/**
 * Class QueryString
 *  
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0 
 * @link     https://github.com/cratia-devel/php_apirest
 */
class QueryString
{
    private $_query;
    
    /**
     * Method
     * Constructor
     */
    public function __construct(string $query = null) 
    {
        if (is_null($query)) {
            $this->_query = array();
        } else {
            parse_str($query, $this->_query);
        }
    }

    /**
     * Method
     * Retrieve a query string item from the request .
     * 
     * @param string $key Clave
     * 
     * @return mixed
     */
    public function get(string $key = null) 
    {
        if (is_null($key)) {
            return $this->_query;    
        } else if (array_key_exists($key, $this->_query)) {
            return $this->_body[$key];
        } else {
            return null;
        }
    }

    /**
     * Method
     * Retrieve a query string item from the request .
     * 
     * @return string
     */
    public function toString() 
    {
        return http_build_query($this->_query);
    }
}


?>
