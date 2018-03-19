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

class JVFrameworkManagerViewCpanel extends JViewLegacy {
	
	public function display($tpl = null) {
		$this->checkPlg ();
		
		JHtml::_('behavior.modal');
		
		parent::display ( $tpl );
		$this->addToolbar ();
		$this->addAsset ();
		//FrameworkHelper::addSubmenu ( $this->getName () );
	}
	
	protected function addToolbar() {
		JToolBarHelper::title ( JText::_ ( 'COM_JVFRAMEWORK_MANAGER_CPANEL' ), 'logo.png' );		
	}
	
	protected function addAsset() {
		JHTML::_ ( 'behavior.tooltip' );
		$document = JFactory::getDocument ();
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );
		$document->addScript ( JURI::base () . "components/com_jvframework/assets/js/framework.js" );
	
	}
	protected function checkPlg() {
		$db = JFactory::getDBO ();
		
		if (version_compare ( JVERSION, '1.6', "<" ))
			$db->setQuery ( 'SELECT published FROM #__plugins WHERE element=\'jvframework\'' );
		else
			$db->setQuery ( 'SELECT enabled FROM #__extensions WHERE element=\'jvframework\'' );
		$result = $db->loadResult ();

		if (! isset ( $result ) || $result == 0) {
            JFactory::getApplication()->enqueueMessage('Please install or enable plugin System JV Framework !', 'warning');
		}
	}
}