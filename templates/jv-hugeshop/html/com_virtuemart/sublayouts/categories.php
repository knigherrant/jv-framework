<?php
/**
*
* Shows the products/categories of a category
*
* @package  VirtueMart
* @subpackage
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
 * @version $Id: default.php 6104 2012-06-13 14:15:29Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$categories = $viewData['categories'];
$categories_per_row =  $viewData['categories_per_row'];
$class = isset($viewData['class'])? $viewData['class']: false;;


if ($categories) {

// Category and Columns Counter
$iCol = 1;
$iCategory = 1;

// Calculating Categories Per Row
$category_col = floor ( 12 / $categories_per_row );

// Separator
$verticalseparator = " vertical-separator";
?>
  <div class="category-view<?php echo (!empty($class))?' '.$class:'';?>">
    <div class="row">
    <?php 
    // Start the Output
      foreach ( $categories as $category ) {
        // this is an indicator wether a row needs to be opened or not
            // Category Link
            $caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id , FALSE);
            // Show Category ?>
            <div class="category col-xs-6 col-sm-<?php echo $category_col; ?>">
              <div class="cat-thumb-item">
                <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
                <?php 
                  echo $category->images[0]->displayMediaThumb("",false);
                ?>
                </a>
                <h5 class="cat-caption"><a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>"><?php echo $category->category_name ?></a></h5>
              </div>
            </div>
      <?php }
    ?>
    </div>
  </div>
<?php  } ?>
