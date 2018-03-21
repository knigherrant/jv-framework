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
<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?> blog-wide">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
  <ul>
    <?php foreach ($items as $key=>$item):	?>
    <li class="post">
      <div class="post-body">
	    	<?php if( ($params->get('itemImage') && isset($item->image)) || ( $params->get('itemVideo')  && !empty($item->video) ) || ( !empty($item->gallery) ) ): ?>
					<div class="post-image" style="background-image: url(<?php echo $item->image; ?>)">
						<?php if($params->get('itemVideo') && !empty($item->video)){?>
							<?php echo $item->video ; ?>
							<!-- <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">	
						      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
						      	<span class="videoIcon"></span>
						   </a> -->
						<?php } else { ?>
							<?php if($params->get('itemDateCreated')): ?>
							<span class="post-created">
								<span class="post-created-day"><?php echo JHTML::_('date', $item->created, 'd'); ?></span> 
								<span class="post-created-month"><?php echo JHTML::_('date', $item->created, 'M'); ?></span> 
							</span>
							<?php endif; ?>
					    <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
					      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					    </a>
					    <?php } ?>  
					</div>
					<!-- end image -->
	    	<?php endif; ?>
				<div class="post-content">
					<?php if($params->get('itemAuthorAvatar')): ?>
			      <div class="post-author clearfix">
				      <a class="k2Avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
							<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>"  onError="this.src='<?php echo JUri::base() ?>/templates/jv-gold/images/avatar.png';"/>
						  </a>
				      <?php if($params->get('itemAuthor')): ?>
				      <div class="moduleItemAuthor">
					      <?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
					
								<?php if(isset($item->authorLink)): ?>
								<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
								<?php else: ?>
								<?php echo $item->author; ?>
								<?php endif; ?>
								
								<?php if($params->get('userDescription')): ?>
								<?php echo $item->authorDescription; ?>
								<?php endif; ?>
								
							</div>
							<?php endif; ?>
			      </div>
		      <?php endif; ?>
					<div class="post-meta">
						<?php if($params->get('itemAuthor')): ?>
						<span>
						<?php if(isset($item->authorLink)): ?>
							<span class="meta-label"><?php echo JText::_('TPL_BLOG_BY'); ?></span>
							<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>" class="meta-value"><?php echo $item->author; ?></a>
						<?php else: ?>
							<span class="meta-label"><?php echo JText::_('TPL_BLOG_BY'); ?></span> 
							<span class="meta-value"><?php echo $item->author; ?></span>
						<?php endif; ?>
						</span>
						<?php endif; ?>
						<?php if($params->get('itemCategory')): ?>
						<span>
							<span class="meta-label"><?php echo JText::_('TPL_BLOG_IN'); ?></span>
							<a class="meta-value" href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>	
						</span>						
						<?php endif; ?>
						<?php if($params->get('itemVideo') && !empty($item->video)):?>
							<?php if($params->get('itemDateCreated')): ?>
								<span>
									<span class="meta-label"><?php echo JText::_('TPL_POSTED'); ?> </span>
									<span class="meta-value"><?php echo JHTML::_('date', $item->created , JText::_('TPL_DATE_FORMAT_03')); ?></span> 
								</span>
							<?php endif; ?>
							<!-- End Date -->	
						<?php endif; ?>
						<?php if($params->get('itemHits')): ?>
						<span>
							<span class="meta-label"><?php echo JText::_('K2_READ'); ?></span> <span class="meta-value"><?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?></span>
						</span>
						<?php endif; ?>
						<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>
							<span>
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
					</div>
					<!-- end meta -->
					<!-- Plugins: BeforeDisplay -->
					<?php echo $item->event->BeforeDisplay; ?>

					<!-- K2 Plugins: K2BeforeDisplay -->
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if($params->get('itemTitle')): ?>
					<h4 class="post-title mt-0">
						<a class="moduleItemTitle" title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
					</h4>
					<?php endif; ?>

					
					<?php if($params->get('itemIntroText')): ?>
						<div class="catItemIntroText mt-30">
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

					<?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
		      <div class="moduleItemExtraFields">
			      <b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
			      <ul>
			        <?php foreach ($item->extra_fields as $extraField): ?>
							<?php if($extraField->value != ''): ?>
							<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
								<?php if($extraField->type == 'header'): ?>
								<h4 class="moduleItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
								<?php else: ?>
								<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
								<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
								<?php endif; ?>
								<div class="clr"></div>
							</li>
							<?php endif; ?>
			        <?php endforeach; ?>
			      </ul>
		      </div>
		      <?php endif; ?>
		      <?php if($params->get('itemReadMore') && $item->fulltext): ?>
					<div class="post-readmore">
					<a href="<?php echo $item->link; ?>" class="btn btn-outline-thin btn-md btn-dark btn-radius">
						<?php echo JText::_('K2_READ_MORE'); ?>
					</a>
					</div>
				<?php endif; ?>
				</div>
				<!-- end content -->
				<!-- Plugins: AfterDisplayContent -->
				<?php echo $item->event->AfterDisplayContent; ?>

				<!-- K2 Plugins: K2AfterDisplayContent -->
				<?php echo $item->event->K2AfterDisplayContent; ?>
    	</div>
    	<!-- end body -->
      <!-- Plugins: AfterDisplay -->
      <?php echo $item->event->AfterDisplay; ?>
      <!-- K2 Plugins: K2AfterDisplay -->
      <?php echo $item->event->K2AfterDisplay; ?>
      <div class="clr"></div>
    </li>
    <?php endforeach; ?>
  </ul>
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
