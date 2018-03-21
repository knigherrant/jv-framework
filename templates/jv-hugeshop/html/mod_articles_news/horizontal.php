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
<div class="newsflash-horiz<?php echo $params->get('moduleclass_sfx'); ?> row">
	<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
		<?php $item = $list[$i]; ?>
		<div class="col-md-<?php echo number_format(12/$n, 0); ?>">
			<?php require JModuleHelper::getLayoutPath('mod_articles_news', '_item'); ?>

			<?php if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) : ?>
				<span class="article-separator">&#160;</span>
			<?php endif; ?>
		</div>
	<?php endfor; ?>
</div>
