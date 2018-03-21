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
jimport ( 'joomla.application.component.view' );

class JVFrameworkViewTypographies extends JViewLegacy {
	
	public function __construct($config = array()) {
		parent::__construct ( $config );		
	}
	
	public function display($tpl = null) {
		$this->items = $this->get ( 'Items' );
		$this->pagination = $this->get ( 'pagination' );
		$this->state = $this->get ( 'State' );
		$this->labels = $this->get ( 'Labels' );
		
		parent::display ( $tpl );
		$this->addAsset ();
	}
	
	protected function addToolbar() {	
	}
	
	protected function addAsset() {
		JHTML::_ ( 'behavior.tooltip' );
		$document = JFactory::getDocument ();
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );	
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/google-code-prettify/prettify.css' );
		$document->addScript( JURI::base () . 'components/com_jvframework/assets/google-code-prettify/prettify.js' );
		$document->addScriptDeclaration("jQuery(function($){prettyPrint();});");
	}

}