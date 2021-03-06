<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 8695 2015-02-12 14:05:25Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>
<div class="pd-content">
<?php # Vendor Store Description
echo $this->add_product_link;
if (!empty($this->vendor->vendor_store_desc) and VmConfig::get('show_store_desc', 1)) { ?>
<div class="vendor-store-desc text-center pb-30">
	<div class="vendor-store-desc-body">
		<div class="heading-style1 text-center ">
			<h3 class="text-uppercase"><?php echo $this->vendor->vendor_store_name; ?></h3>
			<div class="heading-sub "><?php echo $this->vendor->vendor_store_desc; ?></div>
			</div>
	</div>	
</div>
<?php } ?>

<?php
# load categories from front_categories if exist
$homepage_categories_per_row  = VmConfig::get ( 'homepage_categories_per_row', 3 );

if ($this->categories and VmConfig::get('show_categories', 1)) echo '<div class="pb-60">'.$this->renderVmSubLayout('categories_carousel',array('categories'=>$this->categories,'categories_per_row' => $homepage_categories_per_row)).'</div>';

# Show template for : topten,Featured, Latest Products if selected in config BE
if (!empty($this->products) ) {
	$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
	echo $this->renderVmSubLayout('products',array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$products_per_row,'showRating'=>$this->showRating)); //$this->loadTemplate('products');
}

?> <?php vmTime('vm view Finished task ','Start'); ?>
</div>