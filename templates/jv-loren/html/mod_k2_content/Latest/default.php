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
$params->set('galleries_rootfolder', 'media/k2/galleries');
$params->set('singlethumbmode', '1');
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2Latest <?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
  <div class="itemList">
  	<div class="carouselOwl" 
		data-items="2" 
		data-itemsdesktop="2" 
		data-itemsdesktopsmall="1" 
		data-itemstablet="1"  
		data-itemstabletsmall = "1" 
		data-itemsmobile = "1" 
		data-pagination="false" 
		data-navigation="true"
	>
    <?php foreach ($items as $key=>$item):	?>
    	<div class="Item">
		    <div class="post-body">
		    	<?php if( ($params->get('itemImage') && isset($item->image)) || ( $params->get('itemVideo')  && !empty($item->video) ) || ( !empty($item->gallery) ) ): ?>
		    	<div class="row">
		    		<div class="col-sm-6">
		    			<div class="post-image">
		    				<?php if( !empty($item->gallery) ) { ?> 
		    					<?php echo JHTML::_('content.prepare', $item->gallery, $params ); ?>
		    				<?php } elseif($params->get('itemVideo') && !empty($item->video)){?>
			    				<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>)">	
							      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
							      	<span class="videoIcon"></span>
							    </a>
		    				<?php } else { ?>
							    <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>)">
							      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
							    </a>
						    <?php } ?>
		    			</div>
		    			<!-- end image -->
		    		</div>
		    		<div class="col-sm-6">
		    	<?php endif; ?>
		    			<div class="post-content">
		    				<!-- Plugins: BeforeDisplay -->
							<?php echo $item->event->BeforeDisplay; ?>

							<!-- K2 Plugins: K2BeforeDisplay -->
							<?php echo $item->event->K2BeforeDisplay; ?>
							<?php if($params->get('itemDateCreated')): ?>
							<div class="post-date-box">
								<div class="date-1"><?php echo JHTML::_('date', $item->created , "d"); ?></div>
								<div class="date-2"><?php echo JHTML::_('date', $item->created , "F Y"); ?></div>
							</div>
							<?php endif; ?>
							<!-- End Date -->	
		    				<?php if($params->get('itemTitle')): ?>
		    				<h4 class="post-title mt-0">
								<a class="moduleItemTitle" title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
							</h4>
							<?php endif; ?>
							<?php if($params->get('itemAuthor') || $params->get('itemCategory')): ?>
							<div class="post-meta">
								<?php if($params->get('itemAuthor')): ?>
									<span>
									<?php if(isset($item->authorLink)): ?>
										<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo JText::_('TPL_BLOG_BY'); ?> <?php echo $item->author; ?></a>
									<?php else: ?>
										<span><?php echo JText::_('TPL_BLOG_BY'); ?> <?php echo $item->author; ?></span>
									<?php endif; ?>
									</span>
								<?php endif; ?>
								<?php if($params->get('itemCategory')): ?>
									<span>
										<a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo JText::_('TPL_BLOG_IN'); ?>  <?php echo $item->categoryname; ?></a>	
									</span>						
								<?php endif; ?>
							</div>
							<?php endif; ?>
							<?php if($params->get('itemIntroText')): ?>
								<div class="catItemIntroText">
						      	<?php echo $item->introtext; ?>
						      	</div>
					      	<?php endif; ?>
							<!-- Plugins: AfterDisplayTitle -->
							<?php echo $item->event->AfterDisplayTitle; ?>

							<!-- K2 Plugins: K2AfterDisplayTitle -->
							<?php echo $item->event->K2AfterDisplayTitle; ?>

							<!-- Plugins: BeforeDisplayContent -->
							<?php echo $item->event->BeforeDisplayContent; ?>

							<!-- K2 Plugins: K2BeforeDisplayContent -->
							<?php echo $item->event->K2BeforeDisplayContent; ?>
							<?php if($params->get('itemTags') && count($item->tags)>0): ?>
								<div class="post-tags">
									<?php foreach ($item->tags as $tag): ?>
									<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>

							<?php if($params->get('itemReadMore') && $item->fulltext): ?>
								<div class="post-readmore">
								<a href="<?php echo $item->link; ?>">
									<?php echo JText::_('TPL_CONTINUE_READING'); ?>
								</a>
								</div>
							<?php endif; ?>
		    			</div>
		    	<?php if( ($params->get('itemImage') && isset($item->image)) || ( $params->get('itemVideo')  && !empty($item->video) ) || ( !empty($item->gallery) ) ): ?>
		    		</div>
		    	</div>
		    	<?php endif; ?>
				<!-- Plugins: AfterDisplayContent -->
				<?php echo $item->event->AfterDisplayContent; ?>

				<!-- K2 Plugins: K2AfterDisplayContent -->
				<?php echo $item->event->K2AfterDisplayContent; ?>

				<!-- Plugins: AfterDisplay -->
				<?php echo $item->event->AfterDisplay; ?>

				<!-- K2 Plugins: K2AfterDisplay -->
				<?php echo $item->event->K2AfterDisplay; ?>
		    </div>
	    </div>
    <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
	<a class="moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
	<div class="k2FeedIcon">
		<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

</div>
