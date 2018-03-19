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

class JVFrameworkManagerController extends JControllerLegacy {
	protected $default_view = 'cpanel';

	/** 
	 * Method to display a view.
	 */
	public function display($cachable = false, $urlparams = false) {
	    // Set default layout
        JFactory::getApplication()->input->set('layout', JFactory::getApplication()->input->get('layout', JFactory::getApplication()->input->get('view', 'cpanel')));
        
		parent::display();
		return $this;
	}
        
        public function clear(){
            jimport('joomla.filesystem.folder');
            $tmpl = JPATH_ROOT.'/cache/jv';
            $related = JPATH_ROOT.'/cache/jvframework';
            if(JFolder::exists($tmpl))  JFolder::delete($tmpl); 
            if(JFolder::exists($related))  JFolder::delete($related); 
            echo JText::_('Clear cache successfull.');
            jexit();
        }
        
        public function buildLess(){
            $less = JV::helper('lessc');
            $less->compileAll();
            exit('Create LESS to CSS Successfull');
        }
        
}