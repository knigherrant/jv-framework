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
jimport( 'joomla.plugin.helper' );

class JVFrameworkHelperEvent extends JVFrameworkHelper{
	protected 		 $_name  = 'event';
	protected static $Observer = array();
	
	/**
	 * Register event to support JV Framework extension
	 *
	 * @param mixed $event
	 * @param mixed $agr
	 * @return
	 */
	public function &register ($event, $agr = array()) {
		JPluginHelper::importPlugin ( 'jvframework' );
	
		$dispatcher = JDispatcher::getInstance ();
		$results = $dispatcher->trigger ( $event, $agr );
	
		return $results;
	}
	
	/**
	 * Register Observer
	 *
	 * @param mixed $Observ
	 * @param mixed $name
	 * @return
	 */
	public function addObserver($Observ, $name) {
		self::$Observer[$name] = $Observ;
	}
	
	/**
	 * Register event to support JV Framework Feature
	 *
	 * @param mixed $event
	 * @param mixed $agr
	 * @return
	 */
	public function fireEvent($event, $args = array()) {
		$result = array();
		
		if (strpos($event, '.')){
			list ( $event, $name ) = explode ( '.', $event );		
		}
		
		foreach (self::$Observer as $key => $Observ) {			
			if((isset($name) && $name != $key)){
				continue;
			}
			
			$call = array($Observ, $event);
				
			if (is_callable($call)){
				$result[] = JV::call($call, $args);
			}
		}
		
		return $result;
	}
	
	
}