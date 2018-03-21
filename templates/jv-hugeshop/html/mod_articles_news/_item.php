<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$item_heading = $params->get('item_heading', 'h4');
?>
<div calss="thumb-item">
	<?php $images = json_decode($item->images);?>
	<div class="pull-left thumb-item-img" style="background-image: url(<?php echo JUri::root(true).'/'.htmlspecialchars($images->image_intro);?>)"></div>
	<div class="">
		<?php if ($params->get('item_title')) : ?>

			<<?php echo $item_heading; ?> class="newsflash-title<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php if ($params->get('link_titles') && $item->link != '') : ?>
				<a href="<?php echo $item->link; ?>">
					<?php echo $item->title; ?>
				</a>
			<?php else : ?>
				<?php echo $item->title; ?>
			<?php endif; ?>
			</<?php echo $item_heading; ?>>

		<?php endif; ?>

		<?php if (!$params->get('intro_only')) : ?>
			<?php echo $item->afterDisplayTitle; ?>
		<?php endif; ?>

		<?php echo $item->beforeDisplayContent; ?>

		<?php echo $item->introtext; ?>

		<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
			<?php echo '<div class="post-readmore"><a href="' . $item->link . '">' . $item->linkText . '</a></div>'; ?>
		<?php endif; ?>
	</div>
</div>
