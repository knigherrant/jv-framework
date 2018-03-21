<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
JHtml::_('bootstrap.tooltip');


?>
<div class="post-meta">
	<?php if ($displayData['params']->get('show_publish_date')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.publish_date', $displayData); ?>
	<?php endif; ?>
	<?php if ($displayData['params']->get('show_author') && !empty($displayData['item']->author )) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.author', $displayData); ?>
	<?php endif; ?>
	<?php if ($displayData['params']->get('show_parent_category') && !empty($displayData['item']->parent_slug)) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.parent_category', $displayData); ?>
	<?php endif; ?>

	<?php if ($displayData['params']->get('show_category')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.category', $displayData); ?>
	<?php endif; ?>
	<?php if ($displayData['params']->get('show_modify_date')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.modify_date', $displayData); ?>
	<?php endif; ?>

	<?php if ($displayData['params']->get('show_hits')) : ?>
		<?php echo JLayoutHelper::render('joomla.content.info_block.hits', $displayData); ?>
	<?php endif; ?>
</div>