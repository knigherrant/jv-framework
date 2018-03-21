<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
JHtml::_('formbehavior.chosen', 'select');

$pageClass = $this->params->get('pageclass_sfx');
?>
<div class="newsfeed-category<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_category_title', 1)) : ?>
		<h2>
			<?php echo JHtml::_('content.prepare', $this->category->title, '', 'com_newsfeeds.category.title'); ?>
		</h2>
	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc row">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<div class="col-sm-2">
					<img src="<?php echo $this->category->getParams()->get('image'); ?>" class="thumbnail" alt="<?php echo JHtml::_('content.prepare', $this->category->title, '', 'com_newsfeeds.category.title'); ?>"/>
				</div>
				
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<div class="<?php echo ($this->params->get('show_description_image') && $this->category->getParams()->get('image'))?"col-sm-10":"col-sm-12" ?>">
					<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_newsfeeds.category'); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php echo $this->loadTemplate('items'); ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
		<div class="cat-children">
			<h3><?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
			<?php echo $this->loadTemplate('children'); ?>
		</div>
	<?php endif; ?>
</div>
