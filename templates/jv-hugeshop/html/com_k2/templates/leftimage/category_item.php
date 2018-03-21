<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);
$flagQuote = false;
?>
<?php
	if($this->item->params->get('catItemExtraFields') && count($this->item->extra_fields)){
		foreach ($this->item->extra_fields as $key=>$extraField){
			if($extraField->value != ''){
				if($extraField->name == 'Quote'){
					$flagQuote = true;
				}
			}
		}
	}
?>
<?php if($flagQuote){ ?>
<article>
	<div class="post-body">
		<blockquote class="post-quote">
			<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->name == 'Quote'): ?>
				<p><?php echo $extraField->value; ?></p>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->name == 'Author'): ?>
				<footer><span title="<?php echo $extraField->value; ?>"><?php echo $extraField->value; ?></span></footer>
				<?php endif; ?>
			<?php endforeach; ?>
		</blockquote>
	</div>
</article>
<?php } else { ?>
<article>
	<div class="post-body">	
		<div class="row">
			<div class="col-sm-5 col-md-4">
				<?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)){ ?>
					<!-- Item image gallery -->
					<div class="post-image">
						<?php if($this->item->params->get('catItemDateCreated')): ?>
						<span class="post-created">
							<span class="post-created-day"><?php echo JHTML::_('date', $this->item->created , 'd'); ?></span> 
							<span class="post-created-month"><?php echo JHTML::_('date', $this->item->created , 'M'); ?></span> 
						</span>
						<?php endif; ?>
						<!-- End Date -->	
						<?php echo $this->item->gallery; ?>						
					</div>
				<?php } else{ ?>
					<?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)){ ?>
					<!-- Item video -->
						<div class="post-image" style="background-image: url(<?php echo $this->item->image; ?>)">
							<?php if($this->item->videoType=='embedded'): ?>
							<div class="catItemVideoEmbedded">
								<?php echo $this->item->video; ?>
							</div>
							<?php else: ?>
							<div class="catItemVideo">
								<?php echo $this->item->video; ?>
							</div>
							<?php endif; ?>
						</div>
					<?php } else{ ?>
						<?php if($this->item->params->get('catItemImage') && !empty($this->item->image)){ ?>
							<!-- Item Image -->
							<div class="post-image" style="background-image: url(<?php echo $this->item->image; ?>)">
								<?php if($this->item->params->get('catItemDateCreated')): ?>
									<span class="post-created">
										<span class="post-created-day"><?php echo JHTML::_('date', $this->item->created , 'd'); ?></span> 
										<span class="post-created-month"><?php echo JHTML::_('date', $this->item->created , 'M'); ?></span> 
									</span>
								<?php endif; ?>
							    <a 
							    	href="<?php echo $this->item->link; ?>" 
							    	title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" 
							    >
							    	<img class="hidden" src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>"/>
							    </a>
							</div>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
			<!-- end col -->
			<div class="col-sm-7 col-md-8">
				<div class="post-content">
					<!-- Plugins: BeforeDisplay -->
					<?php echo $this->item->event->BeforeDisplay; ?>

					<!-- K2 Plugins: K2BeforeDisplay -->
					<?php echo $this->item->event->K2BeforeDisplay; ?>

					<div class="post-meta">	
						<?php if($this->item->params->get('catItemCategory')): ?>
						<span>
							<a class="meta-value" href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
						</span>
						<?php endif; ?>
						<!-- End Category -->
					</div>

					<?php if($this->item->params->get('catItemTitle')): ?>
					<!-- Item title -->
					<h3 class="post-title">
						<?php if ($this->item->params->get('catItemTitleLinked')): ?>
							<a href="<?php echo $this->item->link; ?>">
							<?php echo $this->item->title; ?>
							</a>
						<?php else: ?>
							<?php echo $this->item->title; ?>
						<?php endif; ?>

						<?php if($this->item->params->get('catItemFeaturedNotice') && $this->item->featured): ?>
							<!-- Featured flag -->
							<sup>
								<small class="text-warning"><i class="fa fa-star star"></i> <?php echo JText::_('K2_FEATURED'); ?></small>
							</sup>
						<?php endif; ?>
						<?php if(isset($this->item->editLink)): ?>
						<!-- Item edit link -->
						<sup class="itemEditLink">
							<a class="edit-modal" href="<?php echo $this->item->editLink; ?>">
								<small class="text-primary"><i class="fa fa-edit"></i> <?php echo JText::_('K2_EDIT_ITEM'); ?></small>
							</a>
						</sup>
						<?php endif; ?>
					</h3>
					<?php endif; ?>
					<!-- Plugins: AfterDisplayTitle -->
					<?php echo $this->item->event->AfterDisplayTitle; ?>

					<!-- K2 Plugins: K2AfterDisplayTitle -->
					<?php echo $this->item->event->K2AfterDisplayTitle; ?>
					<div class="post-meta">	
						<?php if($this->item->params->get('catItemAuthor')): ?>
						<span>
							<span class="meta-label"><?php echo JText::_('TPL_BLOG_BY');?> </span>
							<?php if(isset($this->item->author->link) && $this->item->author->link): ?>
								<a class="meta-value" rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
							<?php else: ?>
								<span class="meta-value"><?php echo $this->item->author->name; ?></span>
							<?php endif; ?>
						</span>
						<?php endif; ?>
						<!-- End Author -->
						<?php if($this->item->params->get('catItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
						<span>
							<span class="post-info-comment">
								<span class="meta-label"><?php echo JText::_('K2_COMMENT'); ?>: </span>
								<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
									<!-- K2 Plugins: K2CommentsCounter -->
									<span class="meta-value"><?php echo $this->item->event->K2CommentsCounter; ?></span>
								<?php else: ?>
									<?php if($this->item->numOfComments > 0): ?>
									<a class="meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
										<?php echo $this->item->numOfComments; ?>
									</a>
									<?php else: ?>
									<a class="meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
										0 
									</a>
									<?php endif; ?>
								<?php endif; ?>
							</span>
						</span>						
						<?php endif; ?>
						<!-- End Comments -->
						<?php if($this->item->params->get('catItemRating')): ?>
						<span>
							<span class="post-info-rating" >
								<span class="meta-label"><?php echo JText::_('K2_VOTES'); ?>: </span>
								<span class="meta-value"><?php echo str_replace('(', '', str_replace(')', '', str_replace('votes', '', $this->item->numOfvotes))); ?></span>
							</span>
						</span>
						<!-- End catItemVote -->
						<?php endif; ?>
						<?php if($this->item->params->get('catItemHits')): ?>
						<span>
							<span class="meta-label"><?php echo JText::_('K2_READ'); ?>: </span>
							<span class="meta-value"><?php echo $this->item->hits; ?> <?php echo JText::_('K2_TIMES'); ?></span>
						</span>
						<?php endif; ?>
						<!-- End hits -->
						<?php if($this->item->params->get('catItemDateModified')): ?>
							<!-- Item date modified -->
							<?php if($this->item->modified != $this->nullDate && $this->item->modified != $this->item->created ): ?>
								<span>
									<span class="meta-label"><?php echo JText::_('K2_LAST_MODIFIED_ON'); ?>: </span>
									<span class="meta-value">
										<?php echo JHTML::_('date', $this->item->modified, JText::_('TPL_DATE_FORMAT_03')); ?>
									</span>
								</span>
							<?php endif; ?>
						<?php endif; ?>
						<?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)){ ?>
							<?php if($this->item->params->get('catItemDateCreated')): ?>
								<span>
									<span class="meta-label"><?php echo JText::_('TPL_POSTED'); ?> </span>
									<span class="meta-value"><?php echo JHTML::_('date', $this->item->created , JText::_('TPL_DATE_FORMAT_03')); ?></span> 
								</span>
							<?php endif; ?>
							<!-- End Date -->	
						<?php 	} ?>
					</div>
					<!-- Plugins: BeforeDisplayContent -->
					<?php echo $this->item->event->BeforeDisplayContent; ?>

					<!-- K2 Plugins: K2BeforeDisplayContent -->
					<?php echo $this->item->event->K2BeforeDisplayContent; ?>
					<?php if($this->item->params->get('catItemIntroText')): ?>
					<!-- Item introtext -->
					<div class="catItemIntroText">
					<?php echo $this->item->introtext; ?>
					</div>
					<?php endif; ?>
					<?php if($this->item->params->get('catItemExtraFields') && count($this->item->extra_fields)): ?>
					<!-- Item extra fields -->
					<div class="catItemExtraFields">
						<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
						<ul>
							<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
							<?php if($extraField->value != ''): ?>
							<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
								<?php if($extraField->type == 'header'): ?>
								<h4 class="catItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
								<?php else: ?>
								<span class="catItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
								<span class="catItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
								<?php endif; ?>
							</li>
							<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if($this->item->params->get('catItemAttachments') && count($this->item->attachments)): ?>
					<!-- Item attachments -->
					<span class="catItemInfoItem">
						<h4><span class="fa fa-download hasTooltip" title="<?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?>"></span> <?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></h4>
						<ul class="catItemAttachments iValue">
							<?php foreach ($this->item->attachments as $attachment): ?>
							<li>
							    <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
							    	<?php echo $attachment->title ; ?>
							    </a>
							    <?php if($this->item->params->get('catItemAttachmentsCounter')): ?>
							    <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
							    <?php endif; ?>
							</li>
							<?php endforeach; ?>
						</ul>
					</span>
					<?php endif; ?>
					<!-- Plugins: AfterDisplayContent -->
					<?php echo $this->item->event->AfterDisplayContent; ?>

					<!-- K2 Plugins: K2AfterDisplayContent -->
					<?php echo $this->item->event->K2AfterDisplayContent; ?>
					
					<?php if($this->item->params->get('catItemTags') && count($this->item->tags)): ?>
					<!-- Item tags -->
					<div class="post-tags">
						<strong><?php echo JText::_('K2_TAGGED_UNDER'); ?></strong> 
						<?php foreach ($this->item->tags as $tag): ?>
						<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a> 
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
					<?php if ($this->item->params->get('catItemReadMore')): ?>
					<!-- Item "read more..." link -->
					<span class="post-readmore">
						<a class="btn btn-outline-thin btn-md btn-dark btn-radius" href="<?php echo $this->item->link; ?>">
							<?php echo JText::_('TPL_READ_MORE'); ?>
						</a>	
					</span>					
					<?php endif; ?>
					<!-- Plugins: AfterDisplay -->
					<?php echo $this->item->event->AfterDisplay; ?>

					<!-- K2 Plugins: K2AfterDisplay -->
					<?php echo $this->item->event->K2AfterDisplay; ?>
				</div>
				<!-- End content -->
			</div>
			<!-- end col-8 -->
		</div>
		<!-- end row -->
				
	</div>
</article>
<?php }?>