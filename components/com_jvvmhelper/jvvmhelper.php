<?php
/**
 # com_jvvmhelper - JV VM Helper
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die;
if(!defined('DS')) define ('DS', DIRECTORY_SEPARATOR);
if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');

VmConfig::loadConfig();
$jlang = JFactory::getLanguage();
$tag = $jlang->getTag();
$jlang->load('', JPATH_ADMINISTRATOR,$tag,true);
VmConfig::loadJLang('com_virtuemart',true);
vmJsApi::cssSite();
jimport('joomla.application.component.controller');
// Execute the task.
$controller	= JControllerLegacy::getInstance('JVVMHelper');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
