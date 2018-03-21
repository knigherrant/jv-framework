<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$images = json_decode($this->item->images);
$urls = json_decode($this->item->urls);
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::addIncludePath(JPATH_THEMES .'/'.JFactory::getApplication()->getTemplate(). '/html/com_content');

JHtml::_('behavior.caption');

// Create shortcut to parameters.
$params = $this->item->params;

?>
<article class="item-page<?php echo $this->pageclass_sfx?>  post post-single">
	<div class="row">

		<?php $useDefList = (($params->get('show_author')) 
				or ($params->get('show_category')) 
				or ($params->get('show_parent_category'))
				or ($params->get('show_create_date')) 
				or ($params->get('show_modify_date')) 
				or ($params->get('show_publish_date'))
				or ($params->get('show_hits')) 
				or $params->get('show_print_icon') 
				or $params->get('show_email_icon')
		); ?>
		
		<div class="col-xs-12">
			<div class="post-body">
				
					<?php  if (isset($images->image_fulltext) and !empty($images->image_fulltext)) : ?>
					<div class="post-image">
						<?php $imgfloat = (empty($images->float_fulltext)) ? $params->get('float_fulltext') : $images->float_fulltext; ?>
						<?php echo JLayoutHelper::render('joomla.content.fulltext_image', array('item' => $this->item, 'params' => $params)); ?>
						</div>
					<?php endif; ?>
				
				<div class="post-content">
					
					<?php
					if (!empty($this->item->pagination) && $this->item->pagination && !$this->item->paginationposition && $this->item->paginationrelative)
					{
						echo $this->item->pagination;
					}

					// Title
					if ($params->get('show_title')) : ?>
							<h3>
								<?php echo $this->escape($this->item->title); ?>
							</h3>
					<?php endif; ?>

					<?php if ($useDefList) : ?>
					<div class="post-tools mb-30">
						<!-- Info -->
						<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params)); ?>
						<!-- Icon tools -->
						<?php if ($params->get('access-edit') ||  $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
							<?php echo JLayoutHelper::render('joomla.content.icons', array('item' => $this->item, 'params' => $params, 'print' => $this->print)); ?>
						<?php endif; ?>
					</div>
					<?php endif; ?>


					<?php  if (!$params->get('show_intro')) :
						echo $this->item->event->afterDisplayTitle;
					endif; ?>
					<?php echo $this->item->event->beforeDisplayContent; ?>

					<?php if (isset ($this->item->toc)) : ?>
						<?php echo $this->item->toc; ?>
					<?php endif; ?>

					<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position == '0')) OR ($params->get('urls_position') == '0' AND empty($urls->urls_position)))
							OR (empty($urls->urls_position) AND (!$params->get('urls_position')))) : ?>
						<?php echo $this->loadTemplate('links'); ?>
					<?php endif; ?>
					<?php
					if (!empty($this->item->pagination) AND $this->item->pagination AND !$this->item->paginationposition AND !$this->item->paginationrelative):
						echo $this->item->pagination;
					endif;
					?>
						<?php echo $this->item->text; ?>

					<!-- TAGS -->
					<?php if ($params->get('show_tags', 1) && !empty($this->item->tags)) : ?>
						<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
						<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
					<?php endif; ?>

					<?php
					if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND!$this->item->paginationrelative):
						echo $this->item->pagination;?>
					<?php endif; ?>

						<?php if (isset($urls) AND ((!empty($urls->urls_position) AND ($urls->urls_position == '1')) OR ( $params->get('urls_position') == '1'))) : ?>

						<?php echo $this->loadTemplate('links'); ?>
						<?php endif; ?>
					<?php
					if (!empty($this->item->pagination) AND $this->item->pagination AND $this->item->paginationposition AND $this->item->paginationrelative):
						echo $this->item->pagination;?>
					<?php endif; ?>
					<?php echo $this->item->event->afterDisplayContent; ?>
				</div>
			</div>
		</div>
	</div>
</article>


