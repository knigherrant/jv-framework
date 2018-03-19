<?php
/**
 # com_jvframework - JV Framework
 # @version		1.5.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
 */

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
jimport ( 'joomla.application.component.view' );

class JVFrameworkManagerViewTypography extends JViewLegacy {
		
	public function display($tpl = null) {
		$this->item = $this->get ( 'Item' );
		$this->form = $this->get ( 'Form' );
		$this->state = $this->get ( 'State' );
		
		parent::display ( $tpl );
		$this->addToolbar ();
		$this->addAsset ();
	}
	
	protected function addToolbar() {
		JToolBarHelper::title ( JText::_ ( 'COM_JVFRAMEWORK_MANAGER_TYPOGRAPHY_EDIT' ), 'typographies.png' );
		JToolBarHelper::apply('typography.apply');
		JToolBarHelper::save('typography.save');
		JToolBarHelper::back ();
	}
	
	protected function addAsset() {
		JHTML::_ ( 'behavior.tooltip' );
		$document = JFactory::getDocument ();
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );
	}
}