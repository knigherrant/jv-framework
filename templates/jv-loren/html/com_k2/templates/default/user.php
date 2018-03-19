<?php
/**
 * @version		$Id: user.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

// Get user stuff (do not change)
$user = JFactory::getUser();

?>

<!-- Start K2 User Layout -->

<div id="k2Container" class="userView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
	<?php if(isset($this->addLink) && JRequest::getInt('id')==$user->id): ?>
		<!-- Item add link -->
		<div class="userItemAddLink mb-20">
			<a class="edit-modal btn btn-primary" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->addLink; ?>">
				<i class="fa fa-pencil"></i> <?php echo JText::_('K2_POST_A_NEW_ITEM'); ?>
			</a>
		</div>
		<?php endif; ?>

	<?php if ($this->params->get('userImage') || $this->params->get('userName') || $this->params->get('userDescription') || $this->params->get('userURL') || $this->params->get('userEmail')): ?>
	<div class="userBlock k2Author-1 mb-50">
		<div class="itemAuthorLeft">
			<?php if ($this->params->get('userImage') && !empty($this->user->avatar)): ?>
				<img class="itemAuthorAvatar" src="<?php echo $this->user->avatar; ?>" alt="<?php echo $this->user->name; ?>"  />
			<?php endif; ?>
			<div class="itemAuthorLink">
				<?php if($this->params->get('userFeedIcon',1)): ?>
				<!-- RSS feed icon -->
					<a href="<?php echo $this->feed; ?>" data-toggle="tooltip" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
						<span class="fa fa-rss"></span>
					</a>
				<?php endif; ?>
				<?php if ($this->params->get('userURL') && isset($this->user->profile->url) && $this->user->profile->url): ?>
				   <a href="<?php echo $this->user->profile->url; ?>" target="_blank" rel="me" data-toggle="tooltip" title="<?php echo JText::_('K2_WEBSITE'); ?>"><i class="fa fa-globe"></i></a>
				<?php endif; ?>

				<?php if ($this->params->get('userEmail')): ?>
					<a rel="email" href="mailto:<?php echo $this->user->email; ?>" target="_blank" data-toggle="tooltip" title="<?php echo JText::_('K2_EMAIL'); ?>"><i class="fa fa-envelope-o"></i></a>
				<?php endif; ?>	
			</div>
		</div>
        <div class="itemAuthorDetails">
			<h4 class="mt-0 mb-0">
				<?php echo JText::_('TPL_ABOUT_AUTHOR'); ?>
			</h4>
			<?php if ($this->params->get('userName')): ?>
			<span class="itemAuthorName mb-20 block text-uppercase"><?php echo $this->user->name; ?></span>
			<?php endif; ?>	        
	 		<?php if ($this->params->get('userDescription') && !empty($this->user->profile->description)): ?>
			<?php echo $this->user->profile->description; ?>
			<?php endif; ?>     
        </div>  

		<?php echo $this->user->event->K2UserDisplay; ?>
		
	</div>
	<?php endif; ?>



	<?php if(count($this->items)): ?>
	<!-- Item list -->
	<div class="ItemList">
		<?php foreach ($this->items as $item): ?>
		
		<!-- Start K2 Item Layout -->
		<div class="ItemView<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)) echo ' ItemViewUnpublished'; ?><?php echo ($item->featured) ? ' ItemIsFeatured' : ''; ?> clearfix mb-50">
		
			<!-- Plugins: BeforeDisplay -->
			<?php echo $item->event->BeforeDisplay; ?>
			
			<!-- K2 Plugins: K2BeforeDisplay -->
			<?php echo $item->event->K2BeforeDisplay; ?>
		
		
		  <!-- Plugins: AfterDisplayTitle -->
		  <?php echo $item->event->AfterDisplayTitle; ?>
		  
		  <!-- K2 Plugins: K2AfterDisplayTitle -->
		  <?php echo $item->event->K2AfterDisplayTitle; ?>
		  <?php if($this->params->get('userItemImage') && !empty($item->imageGeneric)): ?>
			<a class="ItemImage pull-left" href="<?php echo $item->link; ?>" style="background-image: url(<?php echo $item->imageGeneric; ?>)" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
		    	<img src="<?php echo JUri::root();?>templates/<?php echo $template;?>/images/transparent.png" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"  />
		    </a>
		  <?php endif; ?>    
		  <div class="ItemBody">

			        

			  <?php if($this->params->get('userItemTitle')): ?>
			  <!-- Item title -->
			 <h6 class="ItemTitle post-title mt-0 mb-10 text-bold text-uppercase">
			  	<?php if ($this->params->get('userItemTitleLinked') && $item->published): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  	<?php if(!$item->published || ($item->publish_up != $this->nullDate && $item->publish_up > $this->now) || ($item->publish_down != $this->nullDate && $item->publish_down < $this->now)): ?>
		  			<sup>
		  				<small class="text-danger"><?php echo JText::_('K2_UNPUBLISHED'); ?></small>
		  			</sup>
	  			<?php endif; ?>
	  			<?php if(isset($item->editLink)): ?>
					<!-- Item edit link -->
					<sup class="itemEditLink">
						<a class="edit-modal" href="<?php echo $item->editLink; ?>">
							<small class="text-primary"><i class="fa fa-edit"></i> <?php echo JText::_('K2_EDIT_ITEM'); ?></small>
						</a>
					</sup>
				<?php endif; ?>
			  </h6>
			  <?php endif; ?>
              
              
			<?php if(
              $this->params->get('userItemDateCreated') ||				
              $this->params->get('userItemTags') ||
			  $this->item->params->get('itemCommentsAnchor') ||
              $this->params->get('userItemDateCreated') 
              ): ?>
              <div class="post-meta mb-20">
                    <?php if($this->params->get('userItemDateCreated')): ?>
                    <!-- Date created -->
                     <span class="ItemDateCreated">
                     	<span class=""> <?php  echo JHTML::_('date',$item->created,'F d, Y');?> </span>
                     </span>
                    <?php endif; ?>
                    
                    
					<?php if($this->params->get('ItemCategory')): ?>
					<!-- Item category name -->
					<span class="ItemCategory">
						<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
						<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
					</span>
					<?php endif; ?>
					<?php if($this->params->get('userItemCommentsAnchor') && ( ($this->params->get('comments') == '2' && !$this->user->guest) || ($this->params->get('comments') == '1')) ): ?>
					<!-- Anchor link to comments below -->
					<span class="userItemCommentsLink">
						<?php if(!empty($item->event->K2CommentsCounter)): ?>
							<!-- K2 Plugins: K2CommentsCounter -->
							<?php echo $item->event->K2CommentsCounter; ?>
						<?php else: ?>
							<?php if($item->numOfComments > 0): ?>
							<a href="<?php echo $item->link; ?>#itemCommentsAnchor">
								<?php echo $item->numOfComments; ?> <?php echo ($item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
							</a>
							<?php else: ?>
							<a href="<?php echo $item->link; ?>#itemCommentsAnchor">
								0 <?php echo JText::_('K2_COMMENT'); ?>
							</a>
							<?php endif; ?>
						<?php endif; ?>
					</span>
					<?php endif; ?>
              </div>
              <?php endif; ?>            
		
			  <!-- Plugins: BeforeDisplayContent -->
			  <?php echo $item->event->BeforeDisplayContent; ?>
			  
			  <!-- K2 Plugins: K2BeforeDisplayContent -->
			  <?php echo $item->event->K2BeforeDisplayContent; ?>
		

			  
			  <?php if($this->params->get('userItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="ItemIntroText">
			  	<?php echo strip_tags(substr($item->introtext, 0,200)."..."); ?>
			  </div>
			  <?php endif; ?>
		
				

			  <!-- Plugins: AfterDisplayContent -->
			  <?php echo $item->event->AfterDisplayContent; ?>
			  
			  <!-- K2 Plugins: K2AfterDisplayContent -->
			  <?php echo $item->event->K2AfterDisplayContent; ?>
				
				<?php if($this->params->get('userItemTags') && count($item->tags)): ?>
				<!-- Item tags -->
				<div class="post-tags mt-10 mb-10">
					<strong><?php echo JText::_('K2_TAGGED_UNDER'); ?></strong>
				    <?php foreach ($item->tags as $tag): ?>
				    <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
				    <?php endforeach; ?>				  
				</div>
				<?php endif; ?>

			  	<?php if ($item->params->get('tagItemReadMore')): ?>
					<div class="post-readmore mt-10">
						<a href="<?php echo $item->link; ?>">
							<?php echo JText::_('K2_READ_MORE'); ?>
						</a>	
					</div>
				<?php endif; ?>
		  </div>

		  <!-- Plugins: AfterDisplay -->
		  <?php echo $item->event->AfterDisplay; ?>
		  
		  <!-- K2 Plugins: K2AfterDisplay -->
		  <?php echo $item->event->K2AfterDisplay; ?>
			
			
		</div>
		<!-- End K2 Item Layout -->
		
		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="k2Pagination">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
	
	<?php endif; ?>

</div>

<!-- End K2 User Layout -->
