<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$js="
//<![CDATA[
jQuery(function($) {
    var header = $('.header-content-17'),
    	header2 = $('.header-content-18')
    	headerContent = $('.header-content'),
    	topbanner = $('.position-top-banner'),
    	module = $('#menu-category-". $module->id."'),
    	title = $('#menu-category-". $module->id." .menu-title'),
    	menu = $('#menu-category-". $module->id." .menu');
    	function menuPosition() {
    		var flag = true;
    		if (header.length) {
	    		topbanner.css({'padding-left': module.outerWidth()});
	    	}
	    	if (header2.length) {
	    		title.click(function() {
					if (module.hasClass('open')) {
						module.removeClass('open');
						flag = false;
					} else {
						module.addClass('open');
						flag = true;
					}
				});
				function checkopen(){
					if (headerContent.hasClass('headroom--not-top')) {
				 		module.removeClass('open');
				 	} else {
				 		if (flag) {
				 			module.addClass('open');
				 		}
				 	}
				}
				checkopen();
				$( window ).scroll(function() {
				 	checkopen();
				});
	    	}
    	}
    	$(window).on(\"load resize\", function () {
			menuPosition();
    	});
});
//]]>
" ;
$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
?>
<?php // The menu class is deprecated. Use nav instead. ?>
<div id="menu-category-<?php echo $module->id; ?>" class="menu-category<?php echo $params->get('moduleclass_sfx'); ?>">
	<div class="menu-category-inner">
		<h4 class="menu-title hidden"><?php echo $module->title; ?><span><span></span><span></span></span></h4>
		<ul class="menu<?php echo $class_sfx;?> list-unstyled list-categories menu-mod"<?php
			$tag = '';
			if ($params->get('tag_id') != null)
			{
				$tag = $params->get('tag_id').'';
				echo ' id="'.$tag.'"';
			}
		?>>
		<?php
		foreach ($list as $i => &$item) :
			$class = 'item-'.$item->id;
			if ($item->id == $active_id)
			{
				$class .= ' current';
			}

			if (in_array($item->id, $path))
			{
				$class .= ' active';
			}
			elseif ($item->type == 'alias')
			{
				$aliasToId = $item->params->get('aliasoptions');
				if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
				{
					$class .= ' active';
				}
				elseif (in_array($aliasToId, $path))
				{
					$class .= ' alias-parent-active';
				}
			}

			if ($item->type == 'separator')
			{
				$class .= ' divider';
			}

			if ($item->deeper)
			{
				$class .= ' deeper';
			}

			if ($item->parent)
			{
				$class .= ' parent';
			}

			if (!empty($class))
			{
				$class = ' class="'.trim($class) .'"';
			}

			echo '<li'.$class.'>';

			// Render the menu item.
			switch ($item->type) :
				case 'separator':
				case 'url':
				case 'component':
				case 'heading':
					require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
					break;

				default:
					require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
					break;
			endswitch;

			// The next item is deeper.
			if ($item->deeper)
			{
				echo '<div class="divsubmenu"><ul class="list-unstyled list-categories">';
			}
			// The next item is shallower.
			elseif ($item->shallower)
			{
				echo '</li>';
				echo str_repeat('</ul></div></li>', $item->level_diff);
			}
			// The next item is on the same level.
			else {
				echo '</li>';
			}
		endforeach;
		?></ul>
	</div>
</div>