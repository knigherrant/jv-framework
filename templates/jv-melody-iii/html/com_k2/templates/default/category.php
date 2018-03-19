<?php
/**
 * @version		$Id: category.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">

		<?php if(isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<div class="boxDescription">

			<?php if(isset($this->addLink)): ?>
			<!-- Item add link -->
			<span class="catItemAddLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->addLink; ?>">
					<?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?>
				</a>
			</span>
			<?php endif; ?>

			<?php if($this->params->get('catImage') && $this->category->image): ?>
			<!-- Category image -->
			<img class="left" alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" src="<?php echo $this->category->image; ?>" />
			<?php endif; ?>

<div>
	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span class="icon-rss"></span>
		</a>
		
	</div>
	<?php endif; ?>
			<?php if($this->params->get('catTitle')): ?>
			<!-- Category title -->
			<h1><?php echo $this->category->name; ?><?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?></h1>
			<?php endif; ?>

			<?php if($this->params->get('catDescription')): ?>
			<!-- Category description -->
			<?php echo $this->category->description; ?>
			<?php endif; ?>
</div>            

			<!-- K2 Plugins: K2CategoryDisplay -->
			<?php echo $this->category->event->K2CategoryDisplay; ?>

			
		</div>
		<?php endif; ?>

		<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
		<!-- Subcategories -->
		<div class="itemListSubCategories cols-<?php echo $this->params->get('subCatColumns'); ?> row">
			<h2><?php echo JText::_('K2_CHILDREN_CATEGORIES'); ?></h2>

			<?php foreach($this->subCategories as $key=>$subCategory): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('subCatColumns'))==0))
				$lastContainer= ' subCategoryContainerLast';
			else
				$lastContainer='';
				
			if( (($key)%($this->params->get('subCatColumns'))==0) || count($this->primary)<$this->params->get('subCatColumns') )
				$first= ' first';
			else
			$first= '';					
			?>

			<div class="<?php echo $first; echo ' col-sm-'.number_format(12/$this->params->get('subCatColumns')).' col-md-'.number_format(12/$this->params->get('subCatColumns'));  ?>  subCategoryContainer<?php echo $lastContainer; ?>">
				<div class="subCategory">
					<?php if($this->params->get('subCatImage') && $subCategory->image): ?>
					<!-- Subcategory image -->
					<a class="left subCategoryImage" href="<?php echo $subCategory->link; ?>">
						<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
					</a>
					<?php endif; ?>

					<?php if($this->params->get('subCatTitle')): ?>
					<!-- Subcategory title -->
					<h3>
						<a href="<?php echo $subCategory->link; ?>">
							<?php echo $subCategory->name; ?><?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$subCategory->numOfItems.')'; ?>
						</a>
					</h3>
					<?php endif; ?>

					<?php if($this->params->get('subCatDescription')): ?>
					<!-- Subcategory description -->
					<?php echo $subCategory->description; ?>
					<?php endif; ?>



					
				</div>
			</div>
			<?php if(($key+1)%($this->params->get('subCatColumns'))==0): ?>
			
			<?php endif; ?>
			<?php endforeach; ?>

			
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>



	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">

		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
		<div id="itemListLeading" class="cols-<?php echo $this->params->get('num_leading_columns'); ?>  row">
			<?php foreach($this->leading as $key=>$item): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_leading_columns'))==0) || count($this->leading)<$this->params->get('num_leading_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
				
			if( (($key)%($this->params->get('num_leading_columns'))==0) || count($this->primary)<$this->params->get('num_leading_columns') )
				$first= ' first';
			else
			$first= '';	
			?>
			
			<div class=" <?php  echo $first; echo ' col-sm-'.number_format(12/$this->params->get('num_leading_columns')).' col-md-'.number_format(12/$this->params->get('num_leading_columns'));  ?> itemContainer <?php echo $lastContainer; ?>">
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_leading_columns'))==0): ?>
			
			<?php endif; ?>
			<?php endforeach; ?>
			
		</div>
		<?php endif; ?>

		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div id="itemListPrimary" class="cols-<?php echo $this->params->get('num_primary_columns'); ?> row">
			<?php foreach($this->primary as $key=>$item): ?>
			
			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_primary_columns'))==0) || count($this->primary)<$this->params->get('num_primary_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			if( (($key)%($this->params->get('num_primary_columns'))==0) || count($this->primary)<$this->params->get('num_primary_columns') )
				$first= ' first';	
			else
				$first= '';
			?>
			
			<div class="<?php  echo $first; echo ' col-sm-'.number_format(12/$this->params->get('num_primary_columns')).' col-md-'.number_format(12/$this->params->get('num_primary_columns'));  ?> itemContainer<?php echo $lastContainer; ?>">
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_primary_columns'))==0): ?>
			
			<?php endif; ?>
			<?php endforeach; ?>
			
		</div>
		<?php endif; ?>

		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
		<div id="itemListSecondary" class="cols-<?php echo $this->params->get('num_secondary_columns'); ?> row">
			<?php foreach($this->secondary as $key=>$item): ?>
			
			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_secondary_columns'))==0) || count($this->secondary)<$this->params->get('num_secondary_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			if( (($key)%($this->params->get('num_secondary_columns'))==0) || count($this->primary)<$this->params->get('num_secondary_columns') )
				$first= ' first';	
			else
				$first= '';	
			?>
			
			<div class="<?php echo $first; echo ' col-sm-'.number_format(12/$this->params->get('num_secondary_columns')).' col-md-'.number_format(12/$this->params->get('num_secondary_columns'));  ?> itemContainer<?php echo $lastContainer; ?>">
				<?php
					// Load category_item.php by default
					$this->item=$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php if(($key+1)%($this->params->get('num_secondary_columns'))==0): ?>
			
			<?php endif; ?>
			<?php endforeach; ?>
			
		</div>
		<?php endif; ?>

		<?php if(isset($this->links) && count($this->links)): ?>
		<!-- Link items -->
		<div id="itemListLinks" class="cols-<?php echo $this->params->get('num_links_columns'); ?>">
			<h3><?php echo JText::_('K2_MORE'); ?></h3>
			<?php foreach($this->links as $key=>$item): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_links_columns'))==0) || count($this->links)<$this->params->get('num_links_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			if( (($key)%($this->params->get('num_links_columns'))==0) || count($this->primary)<$this->params->get('num_links_columns') )
				$first= ' first';	
			else
				$first= '';
				
			?>

				<?php
					// Load category_item_links.php by default
					$this->item=$item;
					echo $this->loadTemplate('item_links');
				?>

			<?php if(($key+1)%($this->params->get('num_links_columns'))==0): ?>
			
			<?php endif; ?>
			<?php endforeach; ?>
			
		</div>
		<?php endif; ?>

	</div>

	<!-- Pagination -->
	<?php if(count($this->pagination->getPagesLinks())): ?>
	<div class="pagination">
		<p class="counter"><?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?></p>
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>

	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->
