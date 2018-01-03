<?php
/**
 * Header.php
 * 
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0
 * @link     https://github.com/cratia-devel/php_apirest
 * PHP Version 7.2.0
 */

/**
 * Class Header
 *  
 * @category Public
 * @package  PACKAGE_EMPTY
 * @author   Carlos A. Ratia V. <cratia@gmail.com>
 * @license  GNU General Public License v3.0 
 * @link     https://github.com/cratia-devel/php_apirest
 */
class Header
{
    private $_header;

    /**
     * Method
     * Constructor
     */
    public function __construct(array $header = null)
    {
        if (!is_null($header)) {
            $this->_header = array();
            foreach ($header as $key =>$value) {
                $this->_header[$key] = $value; 
            }                
        }
        $this->_header = array();
    }

    /**
     * Method
     * Obtiene un valor especifico o todo el header del Response
     * 
     * @param string $attr Clave
     * 
     * @return mixed
     */
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

    /**
     * Method
     * Obtiene un valor especifico o todo el header del Response
     * 
     * @return mixed
     */
    public function getHeader(): array 
    {
        return $this->_header;
    }

    /**
     * Method
     * Establece un valor especifico en el header del Response
     * 
     * @param string $attr  Clave
     * @param mixed  $value Contenido de la clave
     * 
     * @return void
     */
    public static function set(string $attr, $value): void
    {
        header($attr.':'.$value);
    } 
}

?>
