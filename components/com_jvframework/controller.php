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
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class JVFrameworkController extends JControllerLegacy {
	protected $default_view = 'typographies';

	/**
	 * Method to display a view.
	 */
	public function display($cachable = false, $urlparams = false) {
	    // Set default layout
        JFactory::getApplication()->input->set('layout', JFactory::getApplication()->input->get('layout', 'default'));
        
		parent::display();
		return $this;
	}
}