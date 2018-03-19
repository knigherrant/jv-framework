<?php
/**
 * @version     1.0.0
 * @package     com_jvss
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PHPKungfu <info@phpkungfu.club> - http://www.joomalvi.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');
defined( 'DS' ) or define( 'DS', DIRECTORY_SEPARATOR );

// Execute the task.
$controller	= JControllerLegacy::getInstance('Jvss');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
