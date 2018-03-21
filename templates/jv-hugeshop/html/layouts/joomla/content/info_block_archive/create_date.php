<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

?>
<span class="create">
		<i class="fa fa-calendar"></i>
		<time datetime="<?php echo JHtml::_('date', $displayData['item']->created, 'c'); ?>" itemprop="dateCreated">
			<span class="month-year"><?php echo JHtml::_('date', $displayData['item']->publish_up, 'M Y'); ?></span>
		</time>
</span>