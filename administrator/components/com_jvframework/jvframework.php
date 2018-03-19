<?php

/**
  # com_jvframwork - JV Framework
  # @version		1.5.x
  # ------------------------------------------------------------------------
  # author    Open Source Code Solutions Co
  # copyright Copyright (C) 2011 joomlavi.com. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
  # Websites: http://www.joomlavi.com
  # Technical Support:  http://www.joomlavi.com/my-tickets.html
  ------------------------------------------------------------------------- 
  */
// No direct access
defined('_JEXEC') or die('Restricted access');

if (!class_exists('JVFrameworkLoader')) {
    throw new Exception('JV Framework Plugin is missing or disabled, please install or enable JV Framework before use this extension. <br/>Go to <a href="http://joomlavi.com">http://joomlavi.com</a> or contact <a href="mailto:info@joomlavi.com">info@joomlavi.com</a> for infomation about JV Framework !', 500);
}

JVFrameworkLoader::import('framework');
JVFrameworkLoader::import('defines');

require_once (JPATH_COMPONENT . '/helpers/helper.php');

# Load base controller
jimport('joomla.application.component.controller');
unset($GLOBALS['_JREQUEST']);
$controller = JControllerLegacy::getInstance('JVFrameworkManager');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();