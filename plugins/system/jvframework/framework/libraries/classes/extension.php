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

class JVFrameworkExtension implements ArrayAccess{	
	protected $_framework = null;
	
	public function __construct() {
		$this->_framework = JV::getInstance ();
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


?>