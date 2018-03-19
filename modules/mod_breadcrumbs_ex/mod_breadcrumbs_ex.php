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
$background_parallax = $params->get('parallax');
$background_parallax_speed = $params->get('speed', 0.15);
$background_parallax_hOffset = $params->get('horizontalOffset', 0);
$background_parallax_vOffset = $params->get('verticalOffset', 0);
$background_overlay = $params->get('colorBgOverlay');
$background_overlay_opacity = $params->get('opacityBgOverlay', '0');

require JModuleHelper::getLayoutPath('mod_breadcrumbs_ex', $params->get('layout', 'default'));
