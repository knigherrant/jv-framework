<?php
/**
 * sublayout products
 *
 * @package	VirtueMart
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
 * @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
 */

defined('_JEXEC') or die('Restricted access');
$products_per_row = $viewData['products_per_row'];
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}
?>

<?php 
$i = 1;
$html = '';
foreach ($viewData['products'] as $type => $products ) { ?>
	<?php if(!empty($type) and count($products)>0){
		$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); 
		$active = ($i==1)?'active':'';
		?>
		<?php $html .= '<li class="'.$active.'"><a href="#tab'.$type.'" role="tab" data-toggle="tab"><i class="fa fa-'; ?>
			<?php 
				switch ($type) {
				    case 'featured':
				        $html .= 'star';
				        break;
				    case 'latest':
				        $html .= "flash";
				        break;
				    case 'topten':
				        $html .= "flag";
				        break;
				    case 'recent':
				        $html .= "history";
				        break;
				}
			?>			
			<?php $html .= '"></i> '.$productTitle .'</a></li>'; ?>
	<?php // Start the Output
	$i++;
    }
	?>
<?php } ?>
<?php if (!empty($html)) { ?>
	<ul class="nav nav-tabs " role="tablist">
		<?php echo $html; ?>
	</ul>	
<?php } ?>

<div class="tab-content">
<?php
$j = 1;
foreach ($viewData['products'] as $type => $products ) {

	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);

	if(!empty($type) and count($products)>0){
	$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>
	<div class="tab-pane <?php echo ($j==1)?'active':'';?>" id="tab<?php echo $type ?>">
	<?php // Start the Output
    }

	// Calculating Products Per Row
	$cols = floor ( 12 / ($products_per_row - 1) );
	$per_row_sm = ($products_per_row > 1)?($products_per_row - 1):$products_per_row;
	$cols_sm = floor ( 12 / $per_row_sm );
	$per_row_xs = ($per_row_sm > 1)?($per_row_sm - 1):$per_row_sm;
	$cols_xs = floor ( 12 / $per_row_xs );

	$BrowseTotalProducts = count($products);
	$col = 1;
	$nb = 1;
	$row = 1;
	?>
	<div class="row">
	<?php
	foreach ( $products as $product ) {


		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) { ?>
		<?php }
		// Show Products ?>
		<div class="vmProduct<?php echo ' col-xs-'. $cols_xs.' col-sm-'.$cols_sm.' col-md-' . $cols;?>"> 
			<input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 
			<div class="thumb-item">
				<div class="thumb-item-img">
					<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
						<?php
						echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
					</a>
					<span class="thumb-act thumb-act-first vmButtons">
						<?php if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) { 
							$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
						?>
						<a href="javascript:void(0);" class="btn-call"><i class="fa fa-phone"></i></a>
						<?php } else { ?>
							<?php 
								$addtoCartButton = '';
								if(!VmConfig::get('use_as_catalog', 0)){
									if($product->orderable) {
										echo '<a href="javascript:void(0);" class="btn-addcart">'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'</a>';
									} else {
										echo '<a href="'.$product->link.$ItemidStr.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" >'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</a>';
									}
								}
							?>		
						<?php } ?>
						<?php if(class_exists('PlgSystemPopup')){ ?>
							<a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="fa fa-search"></i></a>
						<?php  } ?>						
						<?php if(class_exists('jvmLibs')){
						    echo jvmLibs::loadJCompare($product->virtuemart_product_id);
						    echo jvmLibs::loadJWishlist($product->virtuemart_product_id);
						} ?>
					</span>

				</div>
				<div class="thumb-item-content">
					<div class="rating-vmgird">
						<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
					</div>
					<h3><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h3>
					<?php if ( VmConfig::get ('display_stock', 1)) { ?>
					<span class="vmStock vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
					<?php }?>
					<div class="vm3pr-prices"> <?php
						echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$product,'currency'=>$currency)); ?>
					</div>
					<div class="list-content hidden">
						<div class="rating-vmgird">
							<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
						</div>
						<div class="product_s_desc">
							<?php // Product Short Description
							if (!empty($product->product_s_desc)) {
								echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 350, ' ...') ?>
							<?php } ?>
						</div>
					</div>
					
					<?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row], 'position' => array('ontop', 'addtocart'))); ?>
				</div>
			</div>
		</div>

		<?php
	}
	?>
	</div>
	<?php

    if(!empty($type)and count($products)>0){
	        // Do we need a final closing row tag?
	        //if ($col != 1) {
	      ?>
	</div>
	    <?php
	    // }
    }
    $j++;
}
?>
</div>