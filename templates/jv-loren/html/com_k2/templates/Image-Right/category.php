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
?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?> blog-image blog-image-right">
	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon -->
	<div class="mb-20">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<i class="fa fa-rss"></i> <?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>
		</a>
	</div>
	<?php endif; ?>


	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">

		<?php if(isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<div class="itemListCategory row  mb-50">
			<?php if($this->params->get('catImage') && $this->category->image): ?>
			<!-- Category image -->
			<div class="col-md-2">
				<img alt="<?php echo K2HelperUtilities::cleanHtml($this->category->name); ?>" src="<?php echo $this->category->image; ?>" style="width:<?php echo $this->params->get('catImageWidth'); ?>px; height:auto;" />
			</div>
			<?php endif; ?>
			<div class="col-md-<?php echo ($this->params->get('catImage') && $this->category->image)?'10':'12';?>">
				<?php if($this->params->get('catTitle')): ?>
				<!-- Category title -->
				<h2 class="mt-0"><?php echo $this->category->name; ?><?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?></h2>
				<?php endif; ?>

				<?php if($this->params->get('catDescription')): ?>
				<!-- Category description -->
				<p><?php echo $this->category->description; ?></p>
				<?php endif; ?>
			</div>

			<!-- K2 Plugins: K2CategoryDisplay -->
			<?php echo $this->category->event->K2CategoryDisplay; ?>
		</div>
		<?php endif; ?>

		<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
		<!-- Subcategories -->
		<div class="itemListSubCategories mt-50">
			<h3 class="mt-0 mb-20"><?php echo JText::_('K2_CHILDREN_CATEGORIES'); ?></h3>
			<div class="row">
			<?php foreach($this->subCategories as $key=>$subCategory): ?>
			<div class="subCategoryContainer mb-40 col-md-<?php echo number_format(12/$this->params->get('subCatColumns'), 0); ?>">
				<div class="subCategory row">
					<?php if($this->params->get('subCatImage') && $subCategory->image): ?>
					<!-- Subcategory image -->
					<div class="col-md-3">
					<a class="subCategoryImage" href="<?php echo $subCategory->link; ?>">
						<img alt="<?php echo K2HelperUtilities::cleanHtml($subCategory->name); ?>" src="<?php echo $subCategory->image; ?>" />
					</a>
					</div>
					<?php endif; ?>

					<div class="col-md-<?php echo ($this->params->get('subCatImage') && $subCategory->image)?'9':'12';?>">
						<?php if($this->params->get('subCatTitle')): ?>
						<!-- Subcategory title -->
						<h4>
							<a href="<?php echo $subCategory->link; ?>">
								<?php echo $subCategory->name; ?><?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$subCategory->numOfItems.')'; ?>
							</a>
						</h4>
						<?php endif; ?>

						<?php if($this->params->get('subCatDescription')): ?>
						<!-- Subcategory description -->
						<p><?php echo $subCategory->description; ?></p>
						<?php endif; ?>

						<!-- Subcategory more... -->
						<a class="subCategoryMore" href="<?php echo $subCategory->link; ?>">
							<?php echo JText::_('K2_VIEW_ITEMS'); ?>
						</a>
					</div>
				</div>
			</div>
			<?php if(($key+1)%($this->params->get('subCatColumns'))==0): ?>
			</div><div class="row">
			<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>



	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">

		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
			<div class="row post">
				<?php foreach($this->leading as $key=>$item): ?>
				<div class="col-md-<?php echo number_format(12/$this->params->get('num_leading_columns'), 0)?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				<?php if(($key+1)%($this->params->get('num_leading_columns'))==0 && ($key + 1) < count($this->leading)): ?>
				</div><div class="row post">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>


		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
			<div class="row post">
				<?php foreach($this->primary as $key=>$item): ?>
				<div class="col-md-<?php echo number_format(12/$this->params->get('num_primary_columns'), 0)?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				<?php if(($key+1)%($this->params->get('num_primary_columns'))==0 && ($key + 1) < count($this->primary)): ?>
				</div><div class="row post">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
			<div class="row post">
				<?php foreach($this->secondary as $key=>$item): ?>
				<div class="col-md-<?php echo number_format(12/$this->params->get('num_secondary_columns'), 0)?>">
					<?php
						// Load category_item.php by default
						$this->item=$item;
						echo $this->loadTemplate('item');
					?>
				</div>
				<?php if(($key+1)%($this->params->get('num_secondary_columns'))==0 && ($key + 1) < count($this->secondary)): ?>
				</div><div class="row post">
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if(isset($this->links) && count($this->links)): ?>
			<div class="catLink mb-50">
				<!-- Link items -->
				<div class="row post">
					<?php foreach($this->links as $key=>$item): ?>
					<div class="col-md-<?php echo number_format(12/$this->params->get('num_links_columns'), 0)?>">
						<?php
							// Load category_item.php by default
							$this->item=$item;
							echo $this->loadTemplate('item_links');
						?>
					</div>
					<?php if(($key+1)%($this->params->get('num_links_columns'))==0 && ($key + 1) < count($this->links)): ?>
					</div><div class="row post">
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="pagination-wrap mt-20">
		<?php if($this->params->get('catPaginationResults')) echo '<div class="pull-left">'.$this->pagination->getPagesCounter().'</div>'; ?>
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>		
	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->
