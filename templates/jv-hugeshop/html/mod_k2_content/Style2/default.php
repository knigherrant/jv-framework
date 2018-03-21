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

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock style-2<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?> blog-wide">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
  <div class="itemList">
  	<div class="row">
		<div class="multi-slides multi-slides-right carouselOwl" 
			data-items="2" 
			data-itemsdesktop="2" 
			data-itemsdesktopsmall="2" 
			data-itemstablet="1"
			data-itemstabletsmall="1"
			data-itemsmobile="1" 
			data-pagination="false" 
			data-navigation=""
		>
	    <?php foreach ($items as $key=>$item):	?>
	    	<div class="col-md-12">
			    <div class="post-body">
			    	<?php if( ($params->get('itemImage') && isset($item->image)) || ( $params->get('itemVideo')  && !empty($item->video) ) || ( !empty($item->gallery) ) ): ?>
	    			<div class="post-image" style="background-image: url(<?php echo $item->image; ?>)">
	    				<?php if($params->get('itemVideo') && !empty($item->video)){?>
		    				<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
						      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
						      	<span class="videoIcon"></span>
						    </a>
	    				<?php } else { ?>
					    <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
					      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					    </a>
					    <?php } ?>   
	    			</div>
	    			<!-- end image -->
			    	<?php endif; ?>
	    			<div class="post-content">
	    				<!-- Plugins: BeforeDisplay -->
						<?php echo $item->event->BeforeDisplay; ?>

						<!-- K2 Plugins: K2BeforeDisplay -->
						<?php echo $item->event->K2BeforeDisplay; ?>
						<?php if($params->get('itemAuthor') || $params->get('itemHits') || $params->get('itemCategory') || ($params->get('itemCommentsCounter') && $componentParams->get('comments')) ): ?>
						<div class="post-meta clearfix">	
							<?php if($params->get('itemHits')): ?>
								<span class="pull-right">
									<span class="meta-label"><i class="huge-eye"></i></span> <span class="meta-value"><?php echo $item->hits; ?></span>
								</span>
							<?php endif; ?>
							<!-- End hits -->						
							<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>		
					      		<span class="pull-right">
					      			<span class="meta-label"><i class="huge-speech"></i></span>
									<?php if(!empty($item->event->K2CommentsCounter)): ?>
										<!-- K2 Plugins: K2CommentsCounter -->
										<?php echo $item->event->K2CommentsCounter; ?>
									<?php else: ?>
										<?php if($item->numOfComments>0): ?>
										<a class="meta-value" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
											<?php echo $item->numOfComments; ?> <?php if($item->numOfComments>1) echo JText::_('K2_COMMENTS'); else echo JText::_('K2_COMMENT'); ?>
										</a>
										<?php else: ?>
										<a class="meta-value" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
											0 <?php echo JText::_('K2_COMMENT'); ?>
										</a>
										<?php endif; ?>
									<?php endif; ?>
								</span>
							<?php endif; ?>
							<?php if($params->get('itemDateCreated')): ?>
							<span class="pull-right">
								<span class="meta-label"><i class="huge-calendar"></i></span> 
								<span class="meta-value"><?php echo JHTML::_('date', $item->created, JText::_("TPL_DATE_FORMAT_07")); ?></span> 
							</span>
							<?php endif; ?>
							<?php if($params->get('itemCategory')): ?>
								<?php if($params->get('itemAuthor') || $params->get('itemAuthorAvatar')): ?>
								<span class="pull-right">
									<?php if($params->get('itemAuthorAvatar')){ ?>
										<a class="post-avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
											<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" />
										</a>
								      <?php } else { ?>
								      	<span class="meta-label"><i class="huge-user"></i></span>
								      <?php } ?>
									<?php if(isset($item->authorLink)): ?>
										<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>" class="meta-value"><?php echo $item->author; ?></a>
									<?php else: ?>
										<span class="meta-value"> <?php echo $item->author; ?></span>
									<?php endif; ?>
								</span>
							<?php endif; ?>
							<span class="pull-left">
								<span class="meta-label"><i class="huge-folder"></i> </span>
								<a class="meta-value" href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>	
							</span>						
							<?php endif; ?>
						</div>
						<?php endif; ?>
	    				<?php if($params->get('itemTitle')): ?>
	    				<h4 class="post-title mt-0">
							<a class="moduleItemTitle" title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
						</h4>
						<?php endif; ?>
						<?php if($params->get('itemIntroText')): ?>
							<div class="post-intro mt-20">
					      		<?php echo strip_tags(substr($item->introtext, 0,140)."..."); ?>
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

						
	    			</div>
    				<?php if($params->get('itemReadMore') && $item->fulltext): ?>
    					<div class="post-readmore mt-30">
							<a class="btn btn-outline-thin btn-sm btn-darker" href="<?php echo $item->link; ?>">
								<?php echo JText::_('TPL_READ_MORE'); ?>
							</a>
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
