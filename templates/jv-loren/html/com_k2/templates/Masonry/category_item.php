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
	<div class="quote-wrapper">
		<div class="jv-quote jv-quote-box1 bg-primary" style="background-image: url(<?php echo $this->item->image; ?>)">
			<blockquote>
				<i class="fa fa-quote-left jv-quote-box-icon"></i>
				<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
					<?php if($extraField->name == 'Quote'): ?>
					<p><?php echo $extraField->value; ?></p>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
					<?php if($extraField->name == 'Author'): ?>
					<footer><?php echo JText::_('TPL_BLOG_BY');?> <span title="<?php echo $extraField->value; ?>"><?php echo $extraField->value; ?></span></footer>
					<?php endif; ?>
				<?php endforeach; ?>
			</blockquote>
		</div>
	</div>	
</article>
<?php } else { ?>
<article class="post mb-30">
	<div class="post-body">
		<?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)){ ?>
			<!-- Item image gallery -->
			<div class="post-image">
				<?php echo $this->item->gallery; ?>
				<?php if($this->item->params->get('catItemDateCreated')): ?>
				<span class="post-date-box">
					<span class="date-1"><?php echo JHTML::_('date', $this->item->created , "d"); ?></span>
					<span class="date-2"><?php echo JHTML::_('date', $this->item->created , "F"); ?></span>
				</span>
				<?php endif; ?>
				<!-- End Date -->
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
				<?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
				<!-- Item Image -->
				<div class="post-image single" style="background-image: url(<?php echo $this->item->image; ?>)">
				    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
				    	<img class="hidden" src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>"/>
				    	<span class="overlay"></span>
				    </a>
				    <?php if($this->item->params->get('catItemDateCreated')): ?>
					<span class="post-date-box">
						<span class="date-1"><?php echo JHTML::_('date', $this->item->created , "d"); ?></span>
						<span class="date-2"><?php echo JHTML::_('date', $this->item->created , "F"); ?></span>
					</span>
					<?php endif; ?>
					<!-- End Date -->
				</div>
				<?php endif; ?>
			<?php } ?>
		<?php } ?>
		<div class="post-content">
			<!-- Item title -->
			<?php if($this->item->params->get('catItemTitle')): ?>
			<h5 class="post-title mt-0">
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
						<small class="text-warning">
							<i class="fa fa-star"></i>
							<?php echo JText::_('K2_FEATURED'); ?>
						</small>
					</sup>
				<?php endif; ?>
				
			</h5>
			<?php endif; ?>
			<?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)):?>
				<?php if($this->item->params->get('catItemDateCreated')): ?>
					<span class="post-date">
						<span><i class="fa fa-calendar"></i> <?php echo JHTML::_('date', $this->item->created , JText::_('TPL_DATE_FORMAT_03')); ?></span>
					</span>
				<?php endif; ?>
			<?php endif; ?>
			<?php if($this->item->params->get('catItemAuthor') || 
				$this->item->params->get('catItemCommentsAnchor') ||
				$this->item->params->get('catItemRating') ||
				$this->item->params->get('catItemHits') ||
				$this->item->params->get('catItemCategory') ): ?>
			<div class="post-meta">
				<?php if($this->item->params->get('catItemAuthor')): ?>
				<span>
					<i class="fa fa-user"></i>
					<?php if(isset($this->item->author->link) && $this->item->author->link): ?>
						<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
					<?php else: ?>
						<span><?php echo $this->item->author->name; ?></span>
					<?php endif; ?>
				</span>
				<?php endif; ?>
				<!-- End Author -->
				
				<?php if($this->item->params->get('catItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
				<span>
					<i class="fa fa-comment"></i> 
					<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
						<!-- K2 Plugins: K2CommentsCounter -->
						<span><?php echo $this->item->event->K2CommentsCounter; ?></span>
					<?php else: ?>
						<?php if($this->item->numOfComments > 0): ?>
						<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
							<?php echo $this->item->numOfComments; ?> 
						</a>
						<?php else: ?>
						<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
							0
						</a>
						<?php endif; ?>
					<?php endif; ?>
				</span>
				<?php endif; ?>
				<!-- End Comments -->
				<?php if($this->item->params->get('catItemRating')): ?>
				<span>
					<?php 
						$votes = array("(", ")", "votes", "Vote");
						?>
					<i class="fa fa-heart"></i> <?php echo str_replace($votes,"", $this->item->numOfvotes); ?>
				</span>
				<!-- End catItemVote -->
				<?php endif; ?>
				<?php if($this->item->params->get('catItemHits')): ?>
				<span>
					<i class="fa fa-eye"></i>
					<?php echo $this->item->hits; ?>
				</span>
				<?php endif; ?>
				<!-- End hits -->
				<?php if($this->item->params->get('catItemCategory')): ?>
				<span>
					<i class="fa fa-folder"></i>
					<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
				</span>
				<?php endif; ?>
				<!-- End Category -->
			</div>
			<?php endif; ?>
			<?php if($this->item->params->get('catItemIntroText')): ?>
			<!-- Item introtext -->
			<div class="catItemIntroText">
			<?php //echo $this->item->introtext; ?>
			<?php echo JHtml::_('string.truncateComplex', $this->item->introtext , 135); ?>
			</div>
			<?php endif; ?>

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
			<div class="post-readmore">
				<a href="<?php echo $this->item->link; ?>">
					<?php echo JText::_('TPL_CONTINUE_READING'); ?>
				</a>
			</div>
			
			<?php endif; ?>
		</div>
	</div>
</article>
<?php }?>