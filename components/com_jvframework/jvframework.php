<?php

/**
  # com_jvframwork - JV Framework
  # @version		1.5.x
  # ------------------------------------------------------------------------
  # author    PHPKungfu Solutions Co
  # copyright Copyright (C) 2011 phpkungfu.club. All Rights Reserved.
  # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
  # Websites: http://www.phpkungfu.club
  # Technical Support:  http://www.phpkungfu.club/my-tickets.html
  ------------------------------------------------------------------------- */
// No direct access
defined('_JEXEC') or die('Restricted access');

if (!class_exists('JVFrameworkLoader')) {
    throw new Exception('JV Framework Plugin is missing or disabled, please install or enable JV Framework before use this extension. <br/>Go to <a href="http://phpkungfu.club">http://phpkungfu.club</a> or contact <a href="mailto:info@phpkungfu.club">info@phpkungfu.club</a> for infomation about JV Framework !', 500);
}

JVFrameworkLoader::import('framework');
JVFrameworkLoader::import('defines');

# Load base controller
jimport('joomla.application.component.controller');

$controller = JControllerLegacy::getInstance('JVFramework');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();