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
-------------------------------------------------------------------------
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controlleradmin');

class JVFrameworkManagerControllerStyles extends JControllerAdmin{
	protected $option = 'com_jvframework';
	
	public function __construct($config = array()) {
		parent::__construct($config);		
	}

    function setDefaultTemplate(){
        // Check for request forgeries.
        JSession::checkToken() or jexit ( JText::_('JINVALID_TOKEN') );
       
        $model = $this->getModel(); 
                
        if(!$model->setDefaultTemplate()){
            $msg  = JText::_('SET_DEFAULT_TEMPLATE_ERROR_MESSAGE');
            $type = 'error';
            
        }else{
            $msg  = JText::_('SET_DEFAULT_TEMPLATE_SUCCESS_MESSAGE');
            $type = null;
        }
              
        $this->setRedirect('index.php?option=com_templates&view=styles&filter_search=jv', $msg, $type);
    }
        
    function getModel($name = 'Style', $prefix = 'JVFrameworkManagerModel', $config = array()) {
        return parent::getModel($name, $prefix, $config);
    }
    
    
}