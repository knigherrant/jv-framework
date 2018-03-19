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
require_once dirname ( dirname ( __FILE__ ) ) . '/menuitem.php';

class FlexMenuItemPosition extends FlexMenuItem {
	
	public function getLink($flink = null) {		
		
	}
	
	public function getHtml() {			
		$html = array ();
		$attributes = array ();
				
		$html[] = $this->loadPosition();
		
		return implode ( '', $html );
	}
	
	public function loadPosition() {
		$html = array ();
		//$style = $this->getParam ( 'fxmenu_module_style', '' );
                $style = 'jvnone';
		$positions = $this->getParam ( 'fxmenu_module_pos' );
		if (is_array ( $positions )) {
	
			foreach ( $positions as $position ) {
				$html [] = $this->beginPosition ();
				$html [] = FlexMenuHelper::loadPosition ( $position, $style );
				$html [] = $this->endPosition ();
			}
		}
	
		return implode ( '', $html );
	
	}
	

	public function beginPosition() {
		return '';
	}
	
	public function endPosition() {
		return '';
	}
}