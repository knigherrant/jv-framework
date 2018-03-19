<?php
/**
 * @version		$Id: latest.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Latest Layout -->
<div id="k2Container" class="latestView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php foreach($this->blocks as $key=>$block): ?>
	<div class="latestItemsContainer" style="width:<?php echo number_format(100/$this->params->get('latestItemsCols'), 1); ?>%;">
	
		<?php if($this->source=='categories'): $category=$block; ?>
		
			<?php if($this->params->get('categoryFeed') || $this->params->get('categoryImage') || $this->params->get('categoryTitle') || $this->params->get('categoryDescription')): ?>
			<!-- Start K2 Category block -->
			<div class="latestItemsCategory k2Author-1 mb-50">

				<div class="itemAuthorLeft">
					<?php if ($this->params->get('categoryImage') && !empty($category->image)): ?>
						<img class="itemAuthorAvatar" src="<?php echo $category->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($category->name); ?>" style="height:auto;" />
					<?php endif; ?>
					<div class="itemAuthorLink">
						<?php if($this->params->get('categoryFeed')): ?>
						<!-- RSS feed icon -->
							<a href="<?php echo $category->feed; ?>"  data-toggle="tooltip"  title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
								<span class="fa fa-rss"></span>
							</a>
						<?php endif; ?>
						<!-- RSS feed icon -->
							<a href="<?php echo $category->link; ?>"  data-toggle="tooltip"  title="<?php echo JText::_('K2_READ_MORE'); ?>">
								<span class="fa fa-link"></span>
							</a>
					</div>
				</div>
				<div class="itemAuthorDetails">
					<?php if ($this->params->get('categoryTitle')): ?>
					<h2  class="mt-0 mb-0"><a href="<?php echo $category->link; ?>"><?php echo $category->name; ?></a></h2>
					<?php endif; ?>
			
					<?php if ($this->params->get('categoryDescription') && isset($category->description)): ?>
					<p><?php echo $category->description; ?></p>
					<?php endif; ?>
				</div>
		
				<!-- K2 Plugins: K2CategoryDisplay -->
				<?php echo $category->event->K2CategoryDisplay; ?>
				
			</div>
			<!-- End K2 Category block -->
			<?php endif; ?>
		
		<?php else: $user=$block; ?>
		
		<?php if ($this->params->get('userFeed') || $this->params->get('userImage') || $this->params->get('userName') || $this->params->get('userDescription') || $this->params->get('userURL') || $this->params->get('userEmail')): ?>
			<!-- Start K2 User block -->
			<div class="latestItemsUser k2Author-1 mb-50">
				<div class="itemAuthorLeft">
					<?php if ($this->params->get('userImage') && !empty($user->avatar)): ?>
					<img class="itemAuthorAvatar" src="<?php echo $user->avatar; ?>" alt="<?php echo $user->name; ?>" />
					<?php endif; ?>
					<div class="itemAuthorLink">
						<?php if($this->params->get('userFeedIcon',1)): ?>
						<!-- RSS feed icon -->
							<a href="<?php echo $user->feed; ?>" data-toggle="tooltip" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
								<span class="fa fa-rss"></span>
							</a>
						<?php endif; ?>
						<?php if ($this->params->get('userURL') && isset($user->profile->url)): ?>
							<a rel="me" href="<?php echo $user->profile->url; ?>" target="_blank" data-toggle="tooltip" title="<?php echo JText::_('K2_WEBSITE'); ?>"><i class="fa fa-globe"></i></a>
						<?php endif; ?>

						<?php if ($this->params->get('userEmail')): ?>
							<a href="mailto:<?php echo $user->email; ?>" target="_blank" data-toggle="tooltip" title="<?php echo JText::_('K2_EMAIL'); ?>"><i class="fa fa-envelope-o"></i></a>
						<?php endif; ?>	
					</div>
				</div>
				
				<div class="itemAuthorDetails">
					<h2 class="mt-0 mb-0">
						<?php echo JText::_('TPL_ABOUT_AUTHOR'); ?>
					</h2>
					<?php if ($this->params->get('userName')): ?>
					<span class="itemAuthorName mb-20 block text-uppercase"><?php echo $user->name; ?></span>
					<?php endif; ?>	        
			 		<?php if ($this->params->get('userDescription') && isset($user->profile->description)): ?>
					<?php echo $user->profile->description; ?>
					<?php endif; ?>     
		        </div> 
		
				<?php echo $user->event->K2UserDisplay; ?>
			</div>
			<!-- End K2 User block -->
		<?php endif; ?>
		
		<?php endif; ?>

		<!-- Start Items list -->
		<div class="latestItemList">
		<?php if($this->params->get('latestItemsDisplayEffect')=="first"): ?>
	
			<?php foreach ($block->items as $itemCounter=>$item): K2HelperUtilities::setDefaultImage($item, 'latest', $this->params); ?>
				<?php if($itemCounter==0): ?>
					<?php $this->item=$item; echo $this->loadTemplate('item'); ?>
					<hr class="mb-40" />
				<?php else: ?>
				  <p class="post-title mt-0 mb-0 text-uppercase">
				  	<?php if ($item->params->get('latestItemTitleLinked')): ?>
						<a href="<?php echo $item->link; ?>">
				  		<?php echo $item->title; ?>
				  	</a>
				  	<?php else: ?>
				  	<?php echo $item->title; ?>
				  	<?php endif; ?>
				  </p>
				<?php endif; ?>
			<?php endforeach; ?>
	
		<?php else: ?>
			<?php foreach ($block->items as $item): K2HelperUtilities::setDefaultImage($item, 'latest', $this->params); ?>
			<?php $this->item=$item; echo $this->loadTemplate('item'); ?>
			<?php endforeach; ?>	
		<?php endif; ?>
		</div>
		<!-- End Item list -->

	</div>

	<?php if(($key+1)%($this->params->get('latestItemsCols'))==0): ?>
	
	<?php endif; ?>

	<?php endforeach; ?>
	
</div>
<!-- End K2 Latest Layout -->
