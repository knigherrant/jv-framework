<?php
/**
 * @version		$Id: tag.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Tag Layout -->
<div id="k2Container" class="tagView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
	<?php if($this->params->get('tagFeedIcon',1)): ?>
		<!-- RSS feed icon -->
		<div class="k2FeedIcon mb-20">
			<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
				<span class="fa fa-rss"></span> <?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>
			</a>
		</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<div class="ItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="ItemView <?php echo ($item->featured) ? ' ItemIsFeatured' : ''; ?> clearfix mb-50">
        
			<?php if($item->params->get('tagItemImage',1) && !empty($item->imageGeneric)): ?>
				<!-- Item Image -->
				<a class="ItemImage pull-left" href="<?php echo $item->link; ?>" style="background-image: url(<?php echo $item->imageGeneric; ?>)" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
					<img src="<?php echo JUri::root();?>templates/<?php echo $template;?>/images/transparent.png" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"  />
				</a>
			<?php endif; ?>

			<div class="ItemBody">
				<?php if($item->params->get('tagItemTitle',1)): ?>
				<!-- Item title -->
				<h4 class="ItemTitle text-uppercase post-title mt-0 mb-5">
					<?php if ($item->params->get('tagItemTitleLinked',1)): ?>
					<a href="<?php echo $item->link; ?>">
					<?php echo $item->title; ?>
					</a>
					<?php else: ?>
					<?php echo $item->title; ?>
					<?php endif; ?>
					<?php if(isset($item->editLink)): ?>
						<!-- Item edit link -->
						<sup class="itemEditLink">
							<a class="edit-modal" href="<?php echo $item->editLink; ?>">
								<small class="text-primary"><i class="fa fa-edit"></i> <?php echo JText::_('K2_EDIT_ITEM'); ?></small>
							</a>
						</sup>
					<?php endif; ?>
				</h4>
				<?php endif; ?>

				<?php if(
				$item->params->get('tagItemDateCreated',1) ||
				$item->params->get('tagItemCategory') 
				): ?>
				<div class="post-meta">
					<?php if($item->params->get('tagItemCategory')): ?>
						<span class="text-primary">
							<a class="ItemCategory" href="<?php echo $item->category->link; ?>"><span class="text-primary"><?php echo $item->category->name; ?></span></a>
						</span>
					<?php endif; ?> 
					<?php if($item->params->get('tagItemDateCreated',1)): ?>
					<!-- Date created -->
					<span class="ItemDateCreated">
						<span class="text-primary"> <?php  echo JHTML::_('date',$item->created, JText::_('TPL_DATE_FORMAT_03'));?> </span>
					</span>
					<?php endif; ?>
				</div>
				<?php endif; ?>      

				<?php if($item->params->get('tagItemIntroText',1)): ?>
				<!-- Item introtext -->
				<div class="ItemIntroText mt-20">
					<?php echo strip_tags(substr($item->introtext, 0,200)."..."); ?>
				</div>
				<?php endif; ?>

				<?php if($item->params->get('tagItemExtraFields',0) && count($item->extra_fields)): ?>
				<!-- Item extra fields -->  
				<div class="ItemExtraFields">
					<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
					<ul>
						<?php foreach ($item->extra_fields as $key=>$extraField): ?>
						<?php if($extraField->value != ''): ?>
						<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
						<?php if($extraField->type == 'header'): ?>
						<h4 class="tagItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
						<?php else: ?>
						<span class="tagItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
						<span class="tagItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
						<?php endif; ?>		
						</li>
						<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>			  

				<?php if ($item->params->get('tagItemReadMore')): ?>
					<div class="post-readmore mt-10">
						<a class="btn btn-outline-thin btn-sm btn-dark btn-radius" href="<?php echo $item->link; ?>">
							<?php echo JText::_('K2_READ_MORE'); ?>
						</a>	
					</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<div class="pagination-results pull-left">
		<?php echo $this->pagination->getPagesCounter(); ?>
		</div>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Tag Layout -->
