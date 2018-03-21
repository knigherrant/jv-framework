<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$categoryModel->addImages($categories);
$categories_per_row = vmConfig::get('categories_per_row');
$col_width = floor ( 100 / $categories_per_row);
$numItemsdesktop = ($categories_per_row > 2)?($categories_per_row-2):$categories_per_row;;
$numItemsdesktopsmall = ($numItemsdesktop > 2)?($numItemsdesktop-2):$numItemsdesktop;
$numItemstablet = ($numItemsdesktopsmall > 2)?($numItemsdesktopsmall-2):$numItemsdesktopsmall;
$numItemstabletsmall = ($numItemstablet > 1)?($numItemstablet-1):$numItemstablet;
$numItemsmobile = ($numItemstabletsmall > 1)?($numItemstabletsmall-1):$numItemstabletsmall;
?>

<div class="vm-categories-wall category-view category-carousel<?php echo $class_sfx ?>">
  <div class="carouselOwl" 
    data-items="<?php echo $categories_per_row; ?>" 
    data-itemsdesktop="<?php echo $numItemsdesktop; ?>" 
    data-itemsdesktopsmall="<?php echo $numItemsdesktopsmall; ?>" 
    data-itemstablet="<?php echo $numItemstablet; ?>"
    data-itemstabletsmall="<?php echo $numItemstabletsmall; ?>"
    data-itemsmobile="2" 
    data-pagination="false" 
    data-navigation="false"
  >
    <?php foreach ($categories as $category) : ?>
    <?php
    $caturl = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category->virtuemart_category_id);
    $catname = $category->category_name ;
    ?>
    <div class="category">
    	<div class="cat-thumb-item">
        <a href="<?php echo $caturl; ?>">
          <?php echo $category->images[0]->displayMediaThumb('class="vm-categories-wall-img"',false) ?> 
        </a>
        <h5 class="cat-caption"><a href="<?php echo $caturl; ?>" title="<?php echo $catname; ?>"><?php echo $catname; ?></a></h5>
    	</div>
    </div>
    <?php endforeach; ?>
  </div>
</div>