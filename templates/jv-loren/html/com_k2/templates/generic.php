<?php
/**
 * @version		$Id: generic.php 1913 2013-02-08 22:35:11Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Generic (search/date) Layout -->
<div id="k2Container" class="jvitemListDefault genericView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title') || JRequest::getCmd('task')=='search' || JRequest::getCmd('task')=='date'): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
	</div>
	<?php endif; ?>

	<?php if(JRequest::getCmd('task')=='search' && $this->params->get('googleSearch')): ?>
	<!-- Google Search container -->
	<div id="<?php echo $this->params->get('googleSearchContainer'); ?>"></div>
	<?php endif; ?>

	<?php if(count($this->items) && $this->params->get('genericFeedIcon',1)): ?>
	<!-- RSS feed icon -->
	<p class="k2FeedIcon clearfix">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>" class="hasTooltip pull-right">
			<span class="fa fa-rss"></span>
		</a>
	</p>
	<?php endif; ?>

	<?php if(count($this->items)): ?>

	<div class="ItemList">
		<?php foreach($this->items as $item): ?>

		<!-- Start K2 Item Layout -->
		<div class="ItemView  clearfix mb-50">

			<?php if($this->params->get('genericItemImage') && !empty($item->imageGeneric)): ?>
			  <!-- Item Image -->
				    <a class="ItemImage pull-left" href="<?php echo $item->link; ?>" style="background-image: url(<?php echo $item->imageGeneric; ?>)" title="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>">
				    	<img src="<?php echo JUri::root();?>templates/<?php echo $template;?>/images/transparent.png" alt="<?php if(!empty($item->image_caption)) echo K2HelperUtilities::cleanHtml($item->image_caption); else echo K2HelperUtilities::cleanHtml($item->title); ?>"  />
				    </a>
			  <?php endif; ?>


		  <div class="ItemBody">

		  	<?php if($this->params->get('genericItemTitle')): ?>
			  <!-- Item title -->
			  <h4 class="ItemTitle post-title mt-0 mb-0">
			  	<?php if ($this->params->get('genericItemTitleLinked')): ?>
					<a href="<?php echo $item->link; ?>">
			  		<?php echo $item->title; ?>
			  	</a>
			  	<?php else: ?>
			  	<?php echo $item->title; ?>
			  	<?php endif; ?>
			  </h4>
			  <?php endif; ?>
			  <div class="post-meta mb-20">
				  <?php if($this->params->get('genericItemDateCreated')): ?>
		            <!-- Date created -->
		             <span class="ItemDateCreated">
		             	<span class=""> <?php  echo JHTML::_('date',$item->created,'F d, Y');?> </span>
		             </span>
		            <?php endif; ?>
		            <?php if($this->params->get('genericItemCategory')): ?>
					<!-- Item category name -->
					<span class="ItemCategory">
						<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
						<a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a>
					</span>
					<?php endif; ?>
			  </div>

			  <?php if($this->params->get('genericItemIntroText')): ?>
			  <!-- Item introtext -->
			  <div class="genericItemIntroText">
			  	<?php echo strip_tags(substr($item->introtext, 0,200)."..."); ?>
			  </div>
			  <?php endif; ?>
			  <?php if($this->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
			  <!-- Item extra fields -->
			  <div class="genericItemExtraFields">
			  	<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
			  	<ul>
					<?php foreach ($item->extra_fields as $key=>$extraField): ?>
					<?php if($extraField->value != ''): ?>
					<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
						<?php if($extraField->type == 'header'): ?>
						<h4 class="genericItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
						<?php else: ?>
						<span class="genericItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
						<span class="genericItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
						<?php endif; ?>
					</li>
					<?php endif; ?>
					<?php endforeach; ?>
					</ul>
			    <div class="clr"></div>
			  </div>
			  <?php endif; ?>
				<?php if ($item->params->get('genericItemReadMore')): ?>
					<div class="post-readmore mt-10">
						<a href="<?php echo $item->link; ?>">
							<?php echo JText::_('K2_READ_MORE'); ?>
						</a>	
					</div>
				<?php endif; ?>
		  </div>
		  <!-- end body -->
		</div>
		<!-- End K2 Item Layout -->

		<?php endforeach; ?>
	</div>

	<!-- Pagination -->
	<?php   $pagesTotal = isset($this->pagination->pagesTotal) ? $this->pagination->pagesTotal : $this->pagination->get('pages.total');
	if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination') == 2)) && ($pagesTotal > 1)) : ?>
	<div class="pagination-wrap">
		<?php  if ($this->params->def('show_pagination_results', 1)) : ?>
		<div class="counter"> <?php echo $this->pagination->getPagesCounter(); ?></div>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php  endif; ?>

	<?php else: ?>

	<?php if(!$this->params->get('googleSearch')): ?>
	<!-- No results found -->
	<div id="genericItemListNothingFound">
		<p><b><?php echo JText::_('K2_NO_RESULTS_FOUND'); ?></b></p>
	</div>
	<?php endif; ?>

	<?php endif; ?>

</div>
<!-- End K2 Generic (search/date) Layout -->
