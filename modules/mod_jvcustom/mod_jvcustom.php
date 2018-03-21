<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$textalign 			= $params->get('textalign');
$background 		= $params->get('backgroundimage');
$backgroundColor 	= $params->get('backgroundColor');
$position 			= $params->get('position');
$size 				= $params->get('size');
$parallax 			= $params->get('parallax');
$speed 				= $params->get('speed');
$horizontalOffset 	= $params->get('horizontalOffset', '0');
$verticalOffset 	= $params->get('verticalOffset', '0');
$parent 			= $params->get('parent');
$contents 			= $params->get('contents');
$colorBgOverlay 	= $params->get('colorBgOverlay');
$opacityBgOverlay 	= $params->get('opacityBgOverlay');
$color 				= $params->get('color');
$full 				= $params->get('full_screen');
$video 				= $params->get('video');
$startAt 			= $params->get('startAt');
$stopAt 			= $params->get('stopAt');
$mute 				= $params->get('mute');
$colorOverlay 		= $params->get('colorOverlay');
$opacityOverlay 	= $params->get('opacityOverlay');

if ($params->def('prepare_content', 1))
{
	JPluginHelper::importPlugin('content');
	$contents  = JHtml::_('content.prepare', $contents , '', 'mod_custom.content');
}

require JModuleHelper::getLayoutPath('mod_jvcustom', $params->get('layout', 'default'));
