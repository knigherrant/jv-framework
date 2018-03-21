<?php
/**
 * @version		$Id: latest_item.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Item Layout -->
<div class="ItemView mb-40 post-body">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

  
	

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php echo $this->item->event->K2AfterDisplayTitle; ?>

  <div class="latestItemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="mb-20 post-image" style="background-image: url(<?php echo $this->item->image; ?>);">
	  	<?php if($this->item->params->get('latestItemDateCreated')): ?>
	  		<span class="post-created">
				<span class="post-created-day"><?php  echo JHTML::_('date',$this->item->created,'d');?></span> 
				<span class="post-created-month"><?php  echo JHTML::_('date',$this->item->created,'M');?></span> 
			</span>
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img class="hidden" src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
		    </a>
		<?php endif; ?>
	  </div>
	  <?php endif; ?>
	  <div class="post-content">
	  	<div class="post-meta mb-20">
			<?php if($this->item->params->get('latestItemCategory')): ?>
			<!-- Item category name -->
			<span class="ItemCategory">
				<a class="meta-value" href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
			</span>
			<?php endif; ?>
			<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
			<!-- Anchor link to comments below -->
			<span class="latestItemCommentsLink">
				<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
					<!-- K2 Plugins: K2CommentsCounter -->
					<?php echo $this->item->event->K2CommentsCounter; ?>
				<?php else: ?>
					<?php if($this->item->numOfComments > 0): ?>
					<a class="meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
					</a>
					<?php else: ?>
					<a class="meta-value" href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
					</a>
					<?php endif; ?>
				<?php endif; ?>
			</span>
			<?php endif; ?>
		  </div>
		  <div class="clearfix"></div>
		  	<?php if($this->item->params->get('latestItemTitle')): ?>
			  <!-- Item title -->
			  <h3 class="post-title text-uppercase">
			  	<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
					<a href="<?php echo $this->item->link; ?>">
			  		<?php echo $this->item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $this->item->title; ?>
			  	<?php endif; ?>
			  </h3>
			<?php endif; ?>
			  <?php if($this->item->params->get('latestItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="ItemIntroText">
			  	<?php echo $this->item->introtext; ?>
			  </div>
			  <?php endif; ?>
			  <!-- Plugins: AfterDisplayContent -->
			  <?php echo $this->item->event->AfterDisplayContent; ?>

			  <!-- K2 Plugins: K2AfterDisplayContent -->
			  <?php echo $this->item->event->K2AfterDisplayContent; ?>
			   <?php if($this->item->params->get('latestItemTags') && count($this->item->tags)): ?>
			  <!-- Item tags -->
			  <div class="post-tags">
				    <?php foreach ($this->item->tags as $tag): ?>
				    <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
				    <?php endforeach; ?>
			  </div>
			  <?php endif; ?>
			<?php if($this->params->get('latestItemVideo') && !empty($this->item->video)): ?>
			  <!-- Item video -->
			  <div class="latestItemVideoBlock">
			  	<h3><?php echo JText::_('K2_RELATED_VIDEO'); ?></h3>
				  <span class="latestItemVideo<?php if($this->item->videoType=='embedded'): ?> embedded<?php endif; ?>"><?php echo $this->item->video; ?></span>
			  </div>
			  <?php endif; ?>

				

				<?php if ($this->item->params->get('latestItemReadMore')): ?>
				<!-- Item "read more..." link -->
				<div class="post-readmore">
					<a class="btn btn-outline-thin btn-md btn-dark btn-radius" href="<?php echo $this->item->link; ?>">
						<?php echo JText::_('K2_READ_MORE'); ?>
					</a>
				</div>
				<?php endif; ?>

				

			  <!-- Plugins: AfterDisplay -->
			  <?php echo $this->item->event->AfterDisplay; ?>

			  <!-- K2 Plugins: K2AfterDisplay -->
			  <?php echo $this->item->event->K2AfterDisplay; ?>

	  </div>	  
  </div>	
</div>
<!-- End K2 Item Layout -->
