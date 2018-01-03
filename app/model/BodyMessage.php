<?php
/**
 * BodyMessage.php
 * 
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia. V <cratia@gmail.com>
 * @license  GNU General Public License v3.0
 * @link     https://github.com/cratia-devel/php_apirest
 * PHP Version 7.2.0
 */

/**
 * Class BodyMessage
 *  
 * @category Public
 * @package  Example
 * @author   Carlos A. Ratia. V <cratia@gmail.com>
 * @license  https://github.com/cratia-devel/php_apirest/blob/master/LICENSE 
 * @link     https://github.com/cratia-devel/php_apirest
 */
class BodyMessage
{
    private $_body;

    /**
     * Method
     * Constructor
     */
    public function __construct()
    {
        $this->_body = json_decode(file_get_contents('php://input'), true);
    }

    /**
     * Method
     * Get especifico elemento del Body Message o Todo
     * 
     * @param string $key Clave
     * 
     * @return mixed
     */
    public function get(string $key = null) 
    {
        if (is_null($key)) {
            return $this->_body;    
        } else if (array_key_exists($key, $this->_body)) {
            return $this->_body[$key];
        } else {
            return null;
        }
    }
}

?>