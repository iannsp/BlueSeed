<?php
namespace BlueSeed;

/**
 *
 * This class storage all Database Instances and manage It
 * @author ivonascimento <ivo@o8o.com.br>
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 *
 */
class DatabaseCollection implements \ArrayAccess, \Iterator, \Countable{
    /**
     *
     * the container where DatabaseConnections are stored
     * @var Array
     * @access private
     */
    private $container = Array();
    /**
     * (non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset,$value) {
         if ($value instanceof DatabaseConnection){
            if ($offset == "") {
                $this->container[] = $value;
            }else {
                $this->container[$offset] = $value;
            }
        } else {
            throw new \Exception("somente coleciona instancias de DatabaseConnection");
        }
    }
    /**
     * (non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset) {
     return isset($this->container[$offset]);
    }
    /**
     * (non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }
    /**
     * (non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
    /**
     * (non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind() {
        reset($this->container);
    }
    /**
     * (non-PHPdoc)
     * @see Iterator::current()
     */
    public function current() {
        return current($this->container);
    }
    /**
     * (non-PHPdoc)
     * @see Iterator::key()
     */
    public function key() {
        return key($this->container);
    }
    /**
     * (non-PHPdoc)
     * @see Iterator::next()
     */
    public function next() {
        return next($this->container);
    }
    /**
     * (non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid() {
        return $this->current() !== false;
    }
    /**
     * (non-PHPdoc)
     * @see Countable::count()
     */
    public function count() {
     return count($this->container);
    }
}

