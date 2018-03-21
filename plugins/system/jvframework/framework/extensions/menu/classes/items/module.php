<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
require_once dirname ( dirname ( __FILE__ ) ) .'/menuitem.php';

class FlexMenuItemModule extends FlexMenuItem {
	
	function getLink($flink = null) {		
		
	}
	
	function getHtml() {
		$html = array ();
		$attributes = array ();
				
		$html[] = $this->loadModule();
		
		return implode ( '', $html );
	}
	
	public function loadModule() {
		$html = array ();	
		$style = $this->getParam ( 'fxmenu_module_style', 'jvxhtml' );
		$modules = $this->getParam ( 'fxmenu_modules' );
		
		if (is_array ( $modules )) {
		
			foreach ( $modules as $module ) {
				$html [] = $this->beginModule ();
				$html [] = FlexMenuHelper::loadModule ( $module, $style );
				$html [] = $this->endModule ();
			}
		}
	
		return implode ( '', $html );
	
	}
	
	public function beginModule() {
		return '';
	}
	
	public function endModule() {
		return '';
	}
}