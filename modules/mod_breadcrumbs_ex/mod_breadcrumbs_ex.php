<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs_ex
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

// Get the breadcrumbs
$list		= ModBreadCrumbsExHelper::getList($params);
$count		= count($list);

$headings	= ModBreadCrumbsExHelper::getHeadings($params);

// Set the default separator
$separator = ModBreadCrumbsExHelper::setSeparator($params->get('separator'));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$background = $params->get('moduleBackground');
$background_position = $params->get('position');
$background_size = $params->get('size');

$parallax = $params->get('parallax');
$speed = $params->get('speed');
$colorBgOverlay = $params->get('colorBgOverlay');
$opacityBgOverlay = $params->get('opacityBgOverlay');

require JModuleHelper::getLayoutPath('mod_breadcrumbs_ex', $params->get('layout', 'default'));
