<?php
/**
*
* Order items view
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk, Valerie Isaksen
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: details_items.php 8310 2014-09-21 17:51:47Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if($this->format == 'pdf'){
	$widthTable = '100';
	$widthTitle = '27';
} else {
	$widthTable = '100';
	$widthTitle = '49';
}

?>
<div class="table-responsive">
	<table class="sectiontableheader table table-striped table-hover table-bordered" width="<?php echo $widthTable ?>%" cellspacing="0" cellpadding="0" border="0">
		<thead>
			<tr  class="sectiontableheader">
				<th  width="5%"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SKU') ?></th>
				<th  colspan="2" width="<?php echo $widthTitle ?>%" ><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_NAME_TITLE') ?></th>
				<th style="text-align: center;" width="10%"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_STATUS') ?></th>
				<th  width="10%" ><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PRICE') ?></th>
				<th  width="5%"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_QTY') ?></th>
				<?php if ( VmConfig::get('show_tax')) { ?>
				<th  width="10%" ><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_TAX') ?></th>
				  <?php } ?>
				<th  width="11%"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SUBTOTAL_DISCOUNT_AMOUNT') ?></th>
				<th  width="10%"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></th>
			</tr>
		</thead>
	<?php
		foreach($this->orderdetails['items'] as $item) {
			$qtt = $item->product_quantity ;
			$_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_category_id=' . $item->virtuemart_category_id . '&virtuemart_product_id=' . $item->virtuemart_product_id, FALSE);
	?>
			<tr valign="top">
				<td >
					<?php echo $item->order_item_sku; ?>
				</td>
				<td  colspan="2" >
					<div><a href="<?php echo $_link; ?>"><?php echo $item->order_item_name; ?></a></div>
					<?php
						if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');
						$product_attribute = VirtueMartModelCustomfields::CustomsFieldOrderDisplay($item,'FE');
						echo $product_attribute;
					?>
				</td>
				<td style="text-align: center;">
					<?php echo $this->orderstatuses[$item->order_status]; ?>
				</td>
				<td    class="priceCol" >
					<?php
					$item->product_discountedPriceWithoutTax = (float) $item->product_discountedPriceWithoutTax;
					if (!empty($item->product_priceWithoutTax) && $item->product_discountedPriceWithoutTax != $item->product_priceWithoutTax) {
						echo '<span class="line-through">'.$this->currency->priceDisplay($item->product_item_price, $this->currency) .'</span><br />';
						echo '<span >'.$this->currency->priceDisplay($item->product_discountedPriceWithoutTax, $this->currency) .'</span><br />';
					} else {
						echo '<span >'.$this->currency->priceDisplay($item->product_item_price, $this->currency) .'</span><br />'; 
					}
					?>
				</td>
				<td  >
					<?php echo $qtt; ?>
				</td>
				<?php if ( VmConfig::get('show_tax')) { ?>
					<td  class="priceCol"><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($item->product_tax ,$this->currency, $qtt)."</span>" ?></td>
	                                <?php } ?>
				<td  class="priceCol" >
					<?php echo  $this->currency->priceDisplay( $item->product_subtotal_discount ,$this->currency);  //No quantity is already stored with it ?>
				</td>
				<td   class="priceCol">
					<?php
					$item->product_basePriceWithTax = (float) $item->product_basePriceWithTax;
					$class = '';
					if(!empty($item->product_basePriceWithTax) && $item->product_basePriceWithTax != $item->product_final_price ) {
						echo '<span class="line-through" >'.$this->currency->priceDisplay($item->product_basePriceWithTax,$this->currency,$qtt) .'</span><br />' ;
					}
					elseif (empty($item->product_basePriceWithTax) && $item->product_item_price != $item->product_final_price) {
						echo '<span class="line-through">' . $this->currency->priceDisplay($item->product_item_price,$this->currency,$qtt) . '</span><br />';
					}

					echo '<span class="product-price">'.$this->currency->priceDisplay(  $item->product_subtotal_with_tax ,$this->currency).'</span>'; //No quantity or you must use product_final_price ?>
				</td>
			</tr>

	<?php
		}
	?>
	 <tr class="sectiontableentry1">
				<td colspan="6" ><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></td>

	                        <?php if ( VmConfig::get('show_tax')) { ?>
				<td ><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_tax,$this->currency)."</span>" ?></td>
	                        <?php } ?>
				<td ><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_discountAmount,$this->currency)."</span>" ?></td>
				<td ><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_salesPrice,$this->currency) ?></td>
			  </tr>
	<?php
	if ($this->orderdetails['details']['BT']->coupon_discount <> 0.00) {
	    $coupon_code=$this->orderdetails['details']['BT']->coupon_code?' ('.$this->orderdetails['details']['BT']->coupon_code.')':'';
		?>
		<tr>
			<td  class="pricePad" colspan="6"><?php echo vmText::_('COM_VIRTUEMART_COUPON_DISCOUNT').$coupon_code ?></td>

			<?php if ( VmConfig::get('show_tax')) { ?>
				<td >&nbsp;</td>
			<?php } ?>
			<td >&nbsp;</td>
			<td ><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->coupon_discount,$this->currency); ?></td>
		</tr>
	<?php  } ?>


		<?php
			foreach($this->orderdetails['calc_rules'] as $rule){
				if ($rule->calc_kind== 'DBTaxRulesBill') { ?>
				<tr >
					<td colspan="6"   class="pricePad"><?php echo $rule->calc_rule_name ?> </td>

	                                   <?php if ( VmConfig::get('show_tax')) { ?>
					<td > </td>
	                                <?php } ?>
					<td > <?php echo  $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></td>
					<td ><?php echo  $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?> </td>
				</tr>
				<?php
				} elseif ($rule->calc_kind == 'taxRulesBill') { ?>
				<tr >
					<td colspan="6"   class="pricePad"><?php echo $rule->calc_rule_name ?> </td>
					<?php if ( VmConfig::get('show_tax')) { ?>
					<td ><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency); ?> </td>
					 <?php } ?>
					<td ><?php    ?> </td>
					<td ><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency);   ?> </td>
				</tr>
				<?php
				 } elseif ($rule->calc_kind == 'DATaxRulesBill') { ?>
				<tr >
					<td colspan="6"    class="pricePad"><?php echo $rule->calc_rule_name ?> </td>
					<?php if ( VmConfig::get('show_tax')) { ?>
					<td > </td>
					 <?php } ?>
					<td ><?php  echo   $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?> </td>
					<td ><span class="product-price"><?php echo $this->currency->priceDisplay($rule->calc_amount,$this->currency);  ?></span> </td>
				</tr>

				<?php
				 }

			}
			?>


		<tr>
			<td  class="pricePad" colspan="6"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING') ?></td>


				<?php if ( VmConfig::get('show_tax')) { ?>
					<td ><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment_tax, $this->currency)."</span>" ?></td>
	                                <?php } ?>
					<td >&nbsp;</td>
					<td ><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_shipment+ $this->orderdetails['details']['BT']->order_shipment_tax, $this->currency); ?></td>

		</tr>

	<tr>
			<td  class="pricePad" colspan="6"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT') ?></td>

				<?php if ( VmConfig::get('show_tax')) { ?>
					<td ><?php echo "<span  class='priceColor2'>".$this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment_tax, $this->currency)."</span>" ?></td>
	                                <?php } ?>
					<td >&nbsp;</td>
					<td ><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_payment+ $this->orderdetails['details']['BT']->order_payment_tax, $this->currency); ?></td>


		</tr>

		<tr>
			<td  class="pricePad" colspan="6"><strong><?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?></strong></td>

			 <?php if ( VmConfig::get('show_tax')) {  ?>
			<td ><span  class='priceColor2'><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_billTaxAmount, $this->currency); ?></span></td>
			 <?php } ?>
			<td ><span  class='priceColor2'><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_billDiscountAmount, $this->currency); ?></span></td>
			<td ><strong><span class="product-price"><?php echo $this->currency->priceDisplay($this->orderdetails['details']['BT']->order_total, $this->currency); ?></span></strong></td>
		</tr>

	</table>
</div>
