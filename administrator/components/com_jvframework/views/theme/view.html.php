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

class JVFrameworkManagerViewTheme extends JViewLegacy {

	public function display($tpl = null) {
		$this->item = $this->get ( 'Item' );
		if(!isset($this->item->extension_id)){
            throw new Exception('Extension not found!', 404);
		}
		$this->form = $this->get ( 'Form' );
		$this->state = $this->get ( 'State' );
		
		parent::display ( $tpl );
		$this->addToolbar ();
		$this->addAsset ();
	}
	
	protected function addToolbar() {
		JToolBarHelper::title ( JText::_ ( 'COM_JVFRAMEWORK_MANAGER_THEME_EDIT' ), 'thememanager.png' );
		JToolBarHelper::back ();
	}
	
	protected function addAsset() {
		$doc = JFactory::getDocument();
		$doc->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );

		$link = JURI::base(true).'/components/com_jvframework/libraries/elfinder-2.0-rc1/';		
		$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');
		$doc->addScript('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js');
		$doc->addScript($link.'js/elfinder.min.js');
		$doc->addStyleSheet($link.'css/elfinder.min.css');
		$doc->addStyleSheet($link.'css/theme.css');
		
		$doc->addScriptDeclaration("				
		jQuery(function($) {
				var elf = $('#elfinder').elfinder({
					url : 'index.php?option=com_jvframework&view=theme&layout=edit&id={$this->item->extension_id}&format=raw'  
				}).elfinder('instance');
			});		
		");
	}
	

}