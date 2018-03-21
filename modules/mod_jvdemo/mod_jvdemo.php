<?php
/*
 # mod_jvdemo - JV Demo Module
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2014 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
?><?php
require_once dirname(__FILE__).'/helper.php';
$jvoption = modJVDemoHelper::getOptions();
$background = modJVDemoHelper::getBackground();
$jStyle = modJVDemoHelper::getStyle();
//Get layout
require(JModuleHelper::getLayoutPath('mod_jvdemo'));
