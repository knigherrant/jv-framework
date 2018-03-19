<?php
/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_jvss')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );

if( !class_exists( 'JvssHelper' ) ) {
    require_once( implode( DS, array( JPATH_ADMINISTRATOR, "components", "com_jvss", "helpers", "jvss.php" ) ) );
}


$controller	= JControllerLegacy::getInstance('Jvss');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
