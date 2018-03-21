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
<ul class="category-module<?php echo $moduleclass_sfx; ?> list-unstyled list-thumbs-pro catagory-images">
	<?php if ($grouped) : ?>
		<span>Set Article Grouping value "None"</span>
	<?php else : ?>
		<?php foreach ($list as $key => $item) : ?>
			<?php $images = json_decode($item->images);?>
			<li class="clearfix product">
				<div class="thumb-item">
					<div class="pull-left thumb-item-img" style="background-image: url(<?php echo JUri::root(true).'/'.htmlspecialchars($images->image_intro);?>)">
					</div>
					<div class="thumb-item-content">
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
							<p class="mod-articles-category-introtext mb-0">
								<?php echo $item->displayIntrotext; ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
