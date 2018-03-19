<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_tags_popular
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<?php JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php'); ?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?>">
<?php if (!count($list) && $params->get('no_results_text')) : ?>
	<div class=""><?php echo JText::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else : ?>
	<ul class="list-unstyled categories-module" >
	<?php foreach ($list as $item) : ?>
	<li><?php $route = new TagsHelperRoute; ?>
		<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($item->tag_id . '-' . $item->alias)); ?>" >
			<?php echo htmlspecialchars($item->title); ?>
			<?php if ($display_count) : ?> (<?php echo $item->count; ?>)<?php endif; ?>
		</a>
		
	</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>
