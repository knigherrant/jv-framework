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

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2Latest<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?> blog-wide">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
	<div class="itemList">
		<?php foreach ($items as $key=>$item):	?>
		    <div class="post-body">				
				<?php if($params->get('itemVideo') && !empty($item->video)){?>
					<div class="post-image">
    				<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>)">	
				      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
				      	<span class="videoIcon"></span>
				    </a>
				    </div>
				<?php } else { ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
					<div class="post-image">
				    <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;" style="background-image: url(<?php echo $item->image; ?>)">
				      	<img class="hidden" src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
				    </a>
				   	</div>
				    <?php } ?>  
			    <?php } ?>				
				<!-- end image -->
				<div class="post-content">
					<!-- Plugins: BeforeDisplay -->
					<?php echo $item->event->BeforeDisplay; ?>

					<!-- K2 Plugins: K2BeforeDisplay -->
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if($params->get('itemTitle')): ?>
					<a class="moduleItemTitle" title="<?php echo $item->title; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
					<?php endif; ?>

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
						<?php if($params->get('itemDateCreated')): ?>
						<span>
							<span><?php echo JHTML::_('date', $item->created, 'M d, Y'); ?></span>
						</span>
						<?php endif; ?>

						<?php if($params->get('itemCategory')): ?>
						<span>
							<a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo JText::_('TPL_BLOG_IN'); ?>  <?php echo $item->categoryname; ?></a>	
						</span>						
						<?php endif; ?>
						
					</div>
					
					<?php if($params->get('itemIntroText')): ?>
						<div class="catItemIntroText mt-20">
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
							<a href="<?php echo $item->link; ?>">
								<?php echo JText::_('K2_READ_MORE'); ?>
							</a>
							</div>
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
		<?php endforeach; ?>
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
