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

class JVFrameworkManagerViewStyle extends JViewLegacy {
	
    protected $jvForm;


    public function display($tpl = null) {
		$this->item = $this->get ( 'Item' );
		$this->form = $this->get ( 'Form' );
		$this->state = $this->get( 'State' );
                if(version_compare(JVERSION,'3.2','<')){
                    $this->jvForm = $this->form;
                }else{
                    $this->jvForm = new JVForm($this->form->getXml(),$this->item );
                }
                

                
		$this->tmpl = $this->get('Desc');
		parent::display ( $tpl );
		$this->addToolbar ();
		$this->addAsset ();
	}
	
	protected function addToolbar() {
		JToolBarHelper::title ( JText::_ ( 'COM_JVFRAMEWORK_MANAGER_STYLE_EDIT' ), 'style.png' );

		JToolBarHelper::custom ( 'style.cpanel', 'back', 'back', 'Cpanel', 0 );
		JToolBarHelper::divider();
		JToolBarHelper::apply ( 'style.apply' );
		JToolBarHelper::save ( 'style.save' );
		//JToolBarHelper::custom ( 'style.reset', 'reset', 'reset', 'Reset to default', 0 );
		JToolBarHelper::cancel ( 'style.cancel' );
	}
	
	protected function addAsset() {
		JHTML::_ ( 'behavior.tooltip' );
		JHTML::_ ( 'behavior.modal' );
		$document = JFactory::getDocument ();
		$document->addStyleSheet ( JURI::base () . 'components/com_jvframework/assets/css/style.css' );		
		$document->addScript ( JURI::base () . "components/com_jvframework/assets/js/framework.js" );
		$document->addScript ( JURI::base () . "components/com_jvframework/assets/js/tab.js" );
		$document->addScript ( JURI::base () . "components/com_jvframework/assets/js/jscolor/jscolor.js" );
		if(version_compare(JVERSION, '3', '>=')){
			JHtml::_('jquery.framework');			
			$document->addScript(JUri::root(true).'/media/jui/js/bootstrap.min.js');
			//$document->addScriptDeclaration("jQuery.fn.chosen = function(){};");
		}
	}

}