<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$params = $this->params;
?>

<div id="archive-items">
	<?php foreach ($this->items as $i => $item) : ?>
		<?php $info = $item->params->get('info_block_position', 0); ?>
		<div class="post mb-50">
				<div class="post-body" itemscope>
				<?php echo JLayoutHelper::render('joomla.content.item_title', array('item' => $item, 'params' => $params, 'title-tag'=>'h6')); ?>

				<?php $useDefList = ($params->get('show_author') || $params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
					|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category')); ?>
				<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
				 <div class="article-aside clearfix">
					<?php echo JLayoutHelper::render('joomla.content.info_block_archive.block', array('item' => $item, 'params' => $params)); ?>
				</div>
				<?php endif; ?>

				<?php if (!$params->get('show_intro')) : ?>
					<?php echo $item->event->afterDisplayTitle; ?>
				<?php endif; ?>
				<?php echo $item->event->beforeDisplayContent; ?>
				<?php if ($params->get('show_intro')) :?>
					<div class="intro mt-20"> <?php echo JHtml::_('string.truncateComplex', $item->introtext, $params->get('introtext_limit')); ?> </div>
				<?php endif; ?>

				<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
				<div class="article-aside mt-20 clearfix">
					<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $item, 'params' => $params)); ?>
				</div>
				<?php endif; ?>
				<?php echo $item->event->afterDisplayContent; ?>
			</div>
		</div>
	<?php endforeach; ?>
</div>
<?php 
$pagesTotal = isset($this->pagination->pagesTotal) ? $this->pagination->pagesTotal : $this->pagination->get('pages.total');
if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $pagesTotal > 1)) : ?>
  <nav class="pagination-wrap clearfix">

    <?php if ($this->params->def('show_pagination_results', 1)) : ?>
      <div class="counter pull-left">
        <?php echo $this->pagination->getPagesCounter(); ?>
      </div>
    <?php  endif; ?>
        <?php echo $this->pagination->getPagesLinks(); ?>
  </nav>
<?php endif; ?>