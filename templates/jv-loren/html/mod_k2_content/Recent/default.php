<?php
/**
 * @version		$Id: default.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2Recent<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
		
	<div class="k2Recent-list carouselOwl" data-items="1" data-singleitem="true" data-pagination="false" data-navigation="true">
		<div class="k2RecentOwl">
		<?php foreach ($items as $key=>$item):	?>
			<div class="k2Recent-item">
				<?php if($params->get('itemImage') && isset($item->image)): ?>
					<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>);">
						<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					</a>
				<?php endif; ?>	      
				<?php if($params->get('itemTitle')): ?>
					<a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
				<?php endif; ?>
				<?php if($params->get('itemIntroText')): ?>
			      	<div class="moduleItemIntrotext">
			      		<?php echo $item->introtext; ?>
			      	</div>
			  	<?php endif; ?>
				<div class="recent-info">
					<?php if($params->get('itemDateCreated')): ?>
					<span class="moduleItemDateCreated"><?php echo JHTML::_('date', $item->created, JText::_('TPL_DATE_FORMAT_03')); ?></span>
					<?php endif; ?>
					<?php if($params->get('itemCategory')): ?>
			    		<a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><i class="fa fa-folder"></i> <?php echo $item->categoryname; ?></a>
			    	<?php endif; ?>
			    	<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>		
						<?php if(!empty($item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<span><?php echo $item->event->K2CommentsCounter; ?></span>
						<?php else: ?>
							<?php if($item->numOfComments>0): ?>
							<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
								<span class="fa fa-comments"></span> <?php echo $item->numOfComments; ?>
							</a>
							<?php else: ?>
							<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
								<span class="fa fa-comments"></span> 0
							</a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($params->get('itemHits')): ?>
					<span class="moduleItemHits" title="<?php echo JText::_('K2_READ'); ?> <?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?>">
						<span class="fa fa-eye"></span> <?php echo $item->hits; ?>
					</span>
					<?php endif; ?>

					<?php if($params->get('itemReadMore') && $item->fulltext): ?>
					<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
						<?php echo JText::_('K2_READ_MORE'); ?>
					</a>
					<?php endif; ?>
				</div>
			  <!-- Plugins: AfterDisplayContent -->
			  <?php echo $item->event->AfterDisplayContent; ?>

			  <!-- K2 Plugins: K2AfterDisplayContent -->
			  <?php echo $item->event->K2AfterDisplayContent; ?>

			  <!-- Plugins: AfterDisplay -->
			  <?php echo $item->event->AfterDisplay; ?>

			  <!-- K2 Plugins: K2AfterDisplay -->
			  <?php echo $item->event->K2AfterDisplay; ?>
			</div>
		<?php if ( ($key+1)% 2 == 0 && ($key + 1) < count($items) ) { ?>
		</div>
		<div class="k2RecentOwl">
		<?php } ?>		
		<?php endforeach; ?>
		</div>
	</div>
  <?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<a class="moduleCustomLink mt-20 inline-block" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?> <i class="fa fa-angle-double-right text-primary"></i></a>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon mt-20">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<i class="fa fa-rss text-primary"></i> <span><?php echo JText::_('TPL_SUBSCRIBE_NOW'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
