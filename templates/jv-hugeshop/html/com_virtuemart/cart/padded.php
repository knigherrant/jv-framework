<?php
/**
*
* Layout for the add to cart popup
*
* @package	VirtueMart
* @subpackage Cart
* @author Max Milbers
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2013 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
<?php
	$virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId ();
	$categoryStr = '';
	if ($virtuemart_category_id) {
		$categoryStr = '&virtuemart_category_id=' . $virtuemart_category_id;
	}

	$ItemidStr = '';
	$Itemid = shopFunctionsF::getLastVisitedItemId();
	if(!empty($Itemid)){
		$ItemidStr = '&Itemid='.$Itemid;
	}
	$this->continue_link = '<a class="continue_link btn btn-dark btn-radius btn-outline btn-sm pull-left" href="' .JRoute::_ ('index.php?option=com_virtuemart&view=category' . $categoryStr.$ItemidStr, FALSE) . '">' . vmText::_ ('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>'; 
?>
<div class="popup-added">
	<div class="popup-added-content clearfix" style="width: 450px;">
	<?php
	if($this->products){
		foreach($this->products as $product){
			if($product->quantity>0){
				echo '<h5 class="product-name">'.vmText::sprintf('COM_VIRTUEMART_CART_PRODUCT_ADDED',$product->product_name,'<span class="gala-border-dashed-2">'.$product->quantity.'</span>').'</h5>';
			} else {
				if(!empty($product->errorMsg)){
					echo '<div>'.$product->errorMsg.'</div>';
				}
			}

		}
	}
	echo '<a class="showcart btn btn-primary btn-radius btn-outline btn-sm pull-right" href="' . JRoute::_('index.php?option=com_virtuemart&view=cart') . '"><i class="gala-shopping82"></i>&nbsp;' . vmText::_('COM_VIRTUEMART_CART_SHOW') . '</a>';
	echo $this->continue_link;
	
	//if ($this->errorMsg) echo '<div>'.$this->errorMsg.'</div>';
	?>
	</div>
	<?php if(VmConfig::get('popup_rel',1)){
		echo '<div class="productdetails-view" style="width: 450px;">';
		//VmConfig::$echoDebug=true;
		if ($this->products and is_array($this->products) and count($this->products)>0 ) {
			$product = reset($this->products);

			$customFieldsModel = VmModel::getModel('customfields');
			$product->customfields = $customFieldsModel->getCustomEmbeddedProductCustomFields($product->allIds,'R');

			$customFieldsModel->displayProductCustomfieldFE($product,$product->customfields);
			if(!empty($product->customfields)){?>
			<div class="product-related-popup related ">
				<h4><?php echo vmText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h4>
				<div class="row">
				<?php
			}
				foreach($product->customfields as $key => $rFields){
					if(!empty($rFields->display)){?>
					<?php echo (($key%4)==0)?'<div class="clearfix"></div>':""; ?>
	                <div class="col-xxs-6 col-xs-3">
						<?php echo $rFields->display ?>
					</div>
					<?php }
					} ?>
				</div>
			</div>
		<?php
		}
		echo '</div>';
	}?>
</div>