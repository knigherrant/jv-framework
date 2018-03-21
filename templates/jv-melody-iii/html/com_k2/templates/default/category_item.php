<?php
/**
 * @version		$Id: category_item.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);

?>

<!-- Start K2 Item Layout -->
<div class="ItemView group<?php echo ucfirst($this->item->itemGroup); ?><?php echo ($this->item->featured) ? ' ItemIsFeatured' : ''; ?><?php if($this->item->params->get('pageclass_sfx')) echo ' '.$this->item->params->get('pageclass_sfx'); ?>">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

	  <?php if($this->item->params->get('catItemTitle')): ?>
	  <!-- Item title -->
	  <h2 class="ItemTitle">
			<?php if(isset($this->item->editLink)): ?>
			<!-- Item edit link -->
			<span class="catItemEditLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
					<?php echo JText::_('K2_EDIT_ITEM'); ?>
				</a>
			</span>
			<?php endif; ?>

	  	<?php if ($this->item->params->get('catItemTitleLinked')): ?>
			<a href="<?php echo $this->item->link; ?>">
	  		<?php echo $this->item->title; ?>
	  	</a>
	  	<?php else: ?>
	  	<?php echo $this->item->title; ?>
	  	<?php endif; ?>


	  </h2>
	  <?php endif; ?>

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php echo $this->item->event->K2AfterDisplayTitle; ?>
  


  <div class="ItemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>

		    <a class="ItemImage" href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>"  />
		    </a>

	  <?php endif; ?>

	  <?php if($this->item->params->get('catItemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="ItemIntroText">
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

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php echo $this->item->event->K2AfterDisplayContent; ?>

	  
  </div>



	

  <?php if($this->item->params->get('catItemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <div class="ItemVideoBlock">
  	<h3><?php echo JText::_('K2_RELATED_VIDEO'); ?></h3>
		<?php if($this->item->videoType=='embedded'): ?>
		<div class="catItemVideoEmbedded">
			<?php echo $this->item->video; ?>
		</div>
		<?php else: ?>
		<span class="catItemVideo"><?php echo $this->item->video; ?></span>
		<?php endif; ?>
  </div>
  <?php endif; ?>

  <?php if($this->item->params->get('catItemImageGallery') && !empty($this->item->gallery)): ?>
  <!-- Item image gallery -->
  <div class="catItemImageGallery">
	  <h4><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h4>
	  <?php echo $this->item->gallery; ?>
  </div>
  <?php endif; ?>

  
    <?php if(
  $this->item->params->get('catItemHits') ||
  $this->item->params->get('catItemCategory') ||
  $this->item->params->get('catItemTags') ||
  $this->item->params->get('catItemDateCreated') ||
  $this->item->params->get('catItemAuthor') ||
  $this->item->params->get('itemCommentsAnchor') ||
  $this->item->params->get('catItemAttachments')
  ): ?>
  <div class="ItemLinks">
  		<?php if($this->item->params->get('catItemDateCreated')): ?>
		<!-- Date created -->
         <span class="ItemDateCreated">
         <span class="icon-calendar"></span>
         <span class="month">  <?php  echo JHTML::_('date',$this->item->created,'F');?> </span>     
         <span class="day"> <?php echo JHTML::_('date',$this->item->created,'d'); ?> </span>
         <span class="years"> <?php  echo JHTML::_('date',$this->item->created,'Y');?> </span>
         </span>
		<?php endif; ?>
		<?php if($this->item->params->get('catItemAuthor')): ?>
		<!-- Item Author -->
		<span class="ItemAuthor">
			
			<?php if(isset($this->item->author->link) && $this->item->author->link): ?>
			<a rel="author" href="<?php echo $this->item->author->link; ?>"><span class="icon-user6"></span> <?php echo $this->item->author->name; ?></a>
			<?php else: ?>
			<?php echo $this->item->author->name; ?>
			<?php endif; ?>
		</span>
		<?php endif; ?>

		<?php if($this->item->params->get('catItemHits')): ?>
		<!-- Item Hits -->

			<span class="ItemHits">
				<span class="icon-eye4"></span> <b><?php echo $this->item->hits; ?></b> <?php echo JText::_('K2_TIMES'); ?>
			</span>

		<?php endif; ?>

		<?php if($this->item->params->get('catItemCategory')): ?>
		<!-- Item category name -->
			<a class="ItemCategory" href="<?php echo $this->item->category->link; ?>"><span class="icon-folder"></span> <?php echo $this->item->category->name; ?></a>
		<?php endif; ?>


	<?php if($this->item->params->get('catItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
	<!-- Anchor link to comments below -->
	<span class="ItemCommentsLink">
		<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
			<!-- K2 Plugins: K2CommentsCounter -->
			<?php echo $this->item->event->K2CommentsCounter; ?>
		<?php else: ?>
			<?php if($this->item->numOfComments > 0): ?>
			<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
			<span class="icon-comments"></span>	<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
			</a>
			<?php else: ?>
			<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
			 <span class="icon-comments"></span>	0 <?php echo JText::_('K2_COMMENT'); ?>
			</a>
			<?php endif; ?>
		<?php endif; ?>
	</span>
	<?php endif; ?>


	  <?php if($this->item->params->get('catItemAttachments') && count($this->item->attachments)): ?>
	  <!-- Item attachments -->
	  <span class="ItemAttachments">

		    <?php foreach ($this->item->attachments as $attachment): ?>
			    <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>">
			    <span class="icon-download"></span>	<?php echo $attachment->title ; ?>
			    </a>
			    <?php if($this->item->params->get('catItemAttachmentsCounter')): ?>
			    <small>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</small>
			    <?php endif; ?>

		    <?php endforeach; ?>

	  </span>
	  <?php endif; ?>

	  <?php if($this->item->params->get('catItemTags') && count($this->item->tags)): ?>
	  <!-- Item tags -->
	  <span class="ItemTags">
		  <span class="icon-tag"></span>
		    <?php foreach ($this->item->tags as $tag): ?>
		    <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
		    <?php endforeach; ?>

		  
	  </span>
	  <?php endif; ?>

		
  </div>
  <?php endif; ?>    

	<?php if($this->item->params->get('catItemRating')): ?>
	<!-- Item Rating -->
	<div class="ItemRatingBlock">
		<div class="itemRatingForm">
			<ul class="itemRatingList">
				<li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a></li>
				<li><a href="#" rel="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a></li>
			</ul>
			<div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"><?php echo $this->item->numOfvotes; ?></div>
			
		</div>
		
	</div>
	<?php endif; ?>


	<?php if ($this->item->params->get('catItemReadMore')): ?>
	<!-- Item "read more..." link -->
	<div class="ItemReadMore">
		<a class="btn btn-default k2ReadMore" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('K2_READ_MORE'); ?>
		</a>
	</div>
	<?php endif; ?>

	

	<?php if($this->item->params->get('catItemDateModified')): ?>
	<!-- Item date modified -->
	<?php if($this->item->modified != $this->nullDate && $this->item->modified != $this->item->created ): ?>
         <div class="ItemDateCreated itemDateModified">
         <span class="icon-calendar"></span>
         <span class="text"><?php echo JText::_('K2_LAST_MODIFIED_ON'); ?></span>
         <span class="month">  <?php  echo JHTML::_('date',$this->item->modified,'F');?> </span>     
         <span class="day"> <?php echo JHTML::_('date',$this->item->modified,'d'); ?> </span>
         <span class="years"> <?php  echo JHTML::_('date',$this->item->modified,'Y');?> </span>
         </div>    
    

    
	<?php endif; ?>
	<?php endif; ?>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php echo $this->item->event->K2AfterDisplay; ?>

	
</div>
<!-- End K2 Item Layout -->
