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

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<h1>
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</h1>
	<?php endif; ?>

	<?php if($this->params->get('tagFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span class="icon-rss"></span>
		</a>
		
	</div>
	<?php endif; ?>

	<?php if(count($this->items)): ?>
	<div class="ItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="ItemView<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)) echo ' ItemViewUnpublished'; ?><?php echo ($item->featured) ? ' ItemIsFeatured' : ''; ?> clearfix">
        
        		<?php if($item->params->get('tagItemImage',1) && !empty($item->imageGeneric)): ?>
			  <!-- Item Image -->
				    <a class="ItemImage" href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
				    	<img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"  />
				    </a>

			  <?php endif; ?>




		  <div class="ItemBody">
          
          				  <?php if($item->params->get('tagItemTitle',1)): ?>
			  <!-- Item title -->
			  <h2 class="ItemTitle">
			  	<?php if ($item->params->get('tagItemTitleLinked',1)): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h2>
			  <?php endif; ?>
              
			  <?php if(
              $item->params->get('tagItemDateCreated',1) ||
              $item->params->get('tagItemCategory') 
              ): ?>
              <div class="ItemLinks">
                            <?php if($item->params->get('tagItemDateCreated',1)): ?>
                            <!-- Date created -->
                     <span class="ItemDateCreated">
                     <span class="icon-calendar"></span>
                     <span class="month">  <?php  echo JHTML::_('date',$item->created,'F');?> </span>     
                     <span class="day"> <?php echo JHTML::_('date',$item->created,'d'); ?> </span>
                     <span class="years"> <?php  echo JHTML::_('date',$item->created,'Y');?> </span>
                     </span>
                            
                            <?php endif; ?>
                            
                            
                        <?php if($item->params->get('tagItemCategory')): ?>
                        
                        <a class="ItemCategory" href="<?php echo $item->category->link; ?>"><span class="icon-folder"></span> <?php echo $item->category->name; ?></a>
                        <?php endif; ?>                
            
                    
              </div>
              <?php endif; ?>      
              
			  <?php if($item->params->get('tagItemIntroText',1)): ?>
			  <!-- Item introtext -->
			  <div class="ItemIntroText">
			  	<?php echo $item->introtext; ?>
			  </div>
			  <?php endif; ?>

		  <?php if($item->params->get('tagItemExtraFields',0) && count($item->extra_fields)): ?>
		  <!-- Item extra fields -->  
		  <div class="ItemExtraFields">
		  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
		  	<ul>
				<?php foreach ($item->extra_fields as $key=>$extraField): ?>
				<?php if($extraField->value != ''): ?>
				<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
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
			<!-- Item "read more..." link -->
			<div class="ItemReadMore">
				<a class="btn btn-default  k2ReadMore" href="<?php echo $item->link; ?>">
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
	<div class="pagination">
		<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
		<?php echo $this->pagination->getPagesLinks(); ?>
		

	</div>
	<?php endif; ?>

	<?php endif; ?>
	
</div>
<!-- End K2 Tag Layout -->
