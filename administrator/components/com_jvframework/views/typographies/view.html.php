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

class JVFrameworkManagerViewTypographies extends JViewLegacy {
		
	public function display($tpl = null) {
		$this->setLayout ( 'typographies' );
		$this->items = $this->get ( 'Items' );
		$this->pagination = $this->get ( 'pagination' );
		$this->state = $this->get ( 'State' );
		$this->labels = $this->get ( 'Labels' );
		
		parent::display ( $tpl );
		$this->addToolbar ();
		$this->addAsset ();
		FrameworkHelper::addSubmenu ( $this->getName () );
	}
	
	protected function addToolbar() {
		JToolBarHelper::title ( JText::_ ( 'COM_JVFRAMEWORK_MANAGER_TYPOGRAPHIES' ), 'typographies.png' );		
		JToolBarHelper::publishList('typographies.publish');
		JToolBarHelper::unpublish('typographies.unpublish');
		JToolBarHelper::divider();
		JToolBarHelper::addNew('typography.add' );
		JToolBarHelper::editList('typography.edit' );
		JToolBarHelper::deleteList ( '', 'typographies.delete' );
		JToolBarHelper::divider();
		JToolBarHelper::back();
	}
	
	protected function addAsset() {
		JHTML::_ ( 'behavior.tooltip' );
		$document = JFactory::getDocument ();
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );
		$document->addScript ( JURI::base () . "components/com_jvframework/assets/js/framework.js" );
	}

}