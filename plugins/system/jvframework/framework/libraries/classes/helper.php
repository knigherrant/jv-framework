<?php
/**
 # JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class JVFrameworkHelper implements ArrayAccess {
	protected $_framework = null;
	protected $_name 	  = '';
	
	public function __construct() {
		$fw = $this->_framework = JV::getInstance ();	
	}
	
	public function getName() {
		return $this->_name;
	}
	
	/**
	 *
	 * @param offset
	 */
	public function offsetExists($offset) {
		return isset ( $this->_framework [$offset] );
	}
	
	/**
	 *
	 * @param offset
	 */
	public function offsetGet($offset) {
		return $this->_framework [$offset];
	}
	
	/**
	 *
	 * @param offset
	 * @param value
	 */
	public function offsetSet($offset, $value) {
		$this->_framework [$offset] = $value;
	}
	
	/**
	 *
	 * @param offset
	 */
	public function offsetUnset($offset) {
		unset ( $this->_framework [$offset] );
	}

}

class JVFrameworkHelperLoader implements ArrayAccess {
	protected $_helper = array ();

	public function addHelper($helper) {
		$name = $helper->getName();

		if (! isset ( $this->_helper [$name] )) {			
			$this->_helper [$name] = $helper;
		}

		return $this->_helper [$name];
	}

	public function getHelper($name) {
		if (! isset ( $this->_helper [$name] )) {
			$class = 'JVFrameworkHelper' . ucfirst ( $name );
			if(!class_exists($class)){
				$path = $this['path']->findPath($name.'.php', 'helpers');
				
				if(is_file($path)){
					require_once $path;
				}else{
					return false;
				}
			}
			
			$this->addHelper(new $class ());
		}

		return $this->_helper [$name];
	}

	/**
	 *
	 * @param offset
	 */
	public function offsetExists($offset) {
		return isset ( $this->_helper [$offset] );
	}

	/**
	 *
	 * @param offset
	 */
	public function offsetGet($offset) {
		return $this->getHelper ( $offset );
	}

	/**
	 *
	 * @param offset
	 * @param value
	 */
	public function offsetSet($offset, $value) {
		$this->_helper [$offset] = $value;
	}

	/**
	 *
	 * @param
	 *        	offset
	 */
	public function offsetUnset($offset) {
		unset ( $this->_helper [$offset] );
	}
}


?>