<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_jvss
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;                                           

$sid = $params->get('ss', 0);

echo JHtml::_( 'content.prepare', "{loadjvss {$sid}}" );
