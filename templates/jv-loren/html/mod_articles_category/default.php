<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_category
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<ul class="category-module<?php echo $moduleclass_sfx; ?> list-unstyled">
	<?php if ($grouped) : ?>
		<?php foreach ($list as $group_name => $group) : ?>
		<li>
			<ul class="list-unstyled">
				<?php foreach ($group as $item) : ?>
					<li>
						<?php if ($params->get('link_titles') == 1) : ?>
					<div class="articles-category-title">
						<a class="mod-articles-category-title <?php echo $item->active; ?> h6 mt-0 block mb-10" href="<?php echo $item->link; ?>">
							<?php echo $item->title; ?>
						</a>
					</div>
				<?php else : ?>
					<div class="articles-category-title h6 mt-0 block mb-10">
						<?php echo $item->title; ?>
					</div>
				<?php endif; ?>
				<?php if ($item->displayHits || $params->get('show_author') || $item->displayCategoryTitle || $item->displayDate) : ?>
					<div class="mod-articles-category-info post-meta pull-none">
						<?php if ($item->displayHits) : ?>
							<span class="mod-articles-category-hits">
								<i class="fa fa-eye"></i> <?php echo $item->displayHits; ?>
							</span>
						<?php endif; ?>
			
						<?php if ($params->get('show_author')) : ?>
							<span class="mod-articles-category-writtenby">
								<i class="fa fa-user"></i> <?php echo $item->displayAuthorName; ?>
							</span>
						<?php endif;?>
			
						<?php if ($item->displayCategoryTitle) : ?>
							<span class="mod-articles-category-category">
								<i class="fa fa-folder"></i> <?php echo $item->displayCategoryTitle; ?>
							</span>
						<?php endif; ?>
			
						<?php if ($item->displayDate) : ?>
							<span class="mod-articles-category-date">
								<i class="fa fa-calendar-o"></i> <?php echo JHtml::_('date', $item->displayDate, 'M Y'); ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

	
				<?php if ($params->get('show_introtext')) : ?>
					<p class="mod-articles-category-introtext mt-10">
						<?php echo $item->displayIntrotext; ?>
					</p>
				<?php endif; ?>
	
				<?php if ($params->get('show_readmore')) : ?>
					<p class="mod-articles-category-readmore post-readmore">
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?php echo $readmore; ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
							<?php else : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					</p>
				<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endforeach; ?>
	<?php else : ?>
		<?php foreach ($list as $item) : ?>
			<li>
				<?php if ($params->get('link_titles') == 1) : ?>
					<div class="articles-category-title">
						<a class="mod-articles-category-title <?php echo $item->active; ?> h6 mt-0 block mb-10" href="<?php echo $item->link; ?>">
							<?php echo $item->title; ?>
						</a>
					</div>
				<?php else : ?>
					<div class="articles-category-title h6 mt-0 block mb-10">
						<?php echo $item->title; ?>
					</div>
				<?php endif; ?>
	
				<?php if ($item->displayHits || $params->get('show_author') || $item->displayCategoryTitle || $item->displayDate) : ?>
					<div class="mod-articles-category-info post-meta pull-none">
						<?php if ($item->displayHits) : ?>
							<span class="mod-articles-category-hits">
								<i class="fa fa-eye"></i> <?php echo $item->displayHits; ?>
							</span>
						<?php endif; ?>
			
						<?php if ($params->get('show_author')) : ?>
							<span class="mod-articles-category-writtenby">
								<i class="fa fa-user"></i> <?php echo $item->displayAuthorName; ?>
							</span>
						<?php endif;?>
			
						<?php if ($item->displayCategoryTitle) : ?>
							<span class="mod-articles-category-category">
								<i class="fa fa-folder"></i> <?php echo $item->displayCategoryTitle; ?>
							</span>
						<?php endif; ?>
			
						<?php if ($item->displayDate) : ?>
							<span class="mod-articles-category-date">
								<i class="fa fa-calendar-o"></i> <?php echo JHtml::_('date', $item->displayDate, 'M Y'); ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>
	
				<?php if ($params->get('show_introtext')) : ?>
					<p class="mod-articles-category-introtext">
						<?php echo $item->displayIntrotext; ?>
					</p>
				<?php endif; ?>
	
				<?php if ($params->get('show_readmore')) : ?>
					<p class="mod-articles-category-readmore post-readmore">
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?php echo $readmore; ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
							<?php else : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					</p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
