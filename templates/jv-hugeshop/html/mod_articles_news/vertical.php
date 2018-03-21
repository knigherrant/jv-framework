<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="newsflash-vert<?php echo $params->get('moduleclass_sfx'); ?> list-unstyled list-thumbs-pro">
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
		<?php $item = $list[$i]; ?>
		<li class="newsflash-item product">
			<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>
		</li>
	<?php endfor; ?>
</ul>
