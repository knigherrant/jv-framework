<?php
/**
 # MOD_JVLATEST_NEWS - JV Latest News
 # @version		3.x
 # ------------------------------------------------------------------------
 # author    Open Source Code Solutions Co
 # copyright Copyright (C) 2013 joomlavi.com. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.joomlavi.com
 # Technical Support:  http://www.joomlavi.com/my-tickets.html
-------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<?php if(isset($catTitle)) { ?><h3><?php echo $catTitle; ?></h3><?php } ?>
<?php if(isset($list->intros) && count($list->intros)){?> 
<div class="jvlatestnews-intro">
<?php 
	//if($columns <1) $columns=1;
	echo "<ul class='row-fluid'>";
	$count = 0;
    foreach ($list->intros as $index => $item) :
        require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/article_single');
		$count ++;
    endforeach; 
	echo "</ul>";
?>
</div>

<?php } ?>
<?php if(isset($list->links) && count($list->links)){?> 
<?php if($params->get('show_more_article_text', 0)){ ?>
    <h2><?php echo JText::_($params->get('more_article_text', '')); ?></h2>
 <?php } ?>
<ul class="jvlatestnews-link">
<?php 
    foreach ($list->links as $item) :
        require JModuleHelper::getLayoutPath('mod_jvlatest_news', $template.'/article_link');
    endforeach; 
?>
</ul>
<?php } ?>
<?php if($params->get('show_link_all', 0)){ ?>
<p class="view_all_cat"><a href="<?php echo $item->linkcat; ?>" ><?php echo JText::_('MOD_JVLATEST_NEWS_VIEW_ALL');?></a></p>
<?php } ?>
