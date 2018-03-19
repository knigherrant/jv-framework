<div class="featured-box featured-box-cart">
	<div class="box-content">
		<div class="table-responsive">
		<table class="table shop_table">
			<thead>
				<tr>
					<th style="min-width: 300px;"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NAME') ?></th>
					<th><?php echo vmText::_ ('COM_VIRTUEMART_CART_SKU') ?></th>
					<th
						><?php echo vmText::_ ('COM_VIRTUEMART_CART_PRICE') ?></th>
					<th style=" width: 202px;">
						<?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?>
						/ <?php echo vmText::_ ('COM_VIRTUEMART_CART_ACTION') ?></th>
					
					<?php if (VmConfig::get ('show_tax')) {
						$tax = vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT');
						if(!empty($this->cart->cartData['VatTax'])){
							if(count($this->cart->cartData['VatTax']) < 2) {
								reset($this->cart->cartData['VatTax']);
								$taxd = current($this->cart->cartData['VatTax']);
								$tax = shopFunctionsF::getTaxNameWithValue($taxd['calc_name'],$taxd['calc_value']);
							}
						}
						?>
					<th class="vm-cart-item-tax" ><?php echo "<span  class='priceColor2'>" . $tax . '</span>' ?></th>
					<?php } ?>
					<th><?php echo "<div>" . vmText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') . '</div>' ?></th>
					<th ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($this->cart->products as $pkey => $prow) {?>
				<tr valign="top" class="sectiontableentry<?php echo $i ?>">
					<td >
						<?php if ($prow->virtuemart_media_id) { ?>
						<div class="cart-images pull-left">
										 <?php
							if (!empty($prow->images[0])) {
								echo $prow->images[0]->displayMediaThumb ('', FALSE);
							}
							?>
						</div>
						<?php } ?>
						<h5 class="cart-product-name">
						<?php 
							echo JHtml::link ($prow->url, $prow->product_name);
						?>
						</h5>
						<?php
							echo $this->customfieldsModel->CustomsFieldCartDisplay ($prow);
						?>
					</td>
					<td ><?php  echo $prow->product_sku ?></td>
					<td class="vm-cart-item-basicprice" >
						<?php
						if (VmConfig::get ('checkout_show_origprice', 1) && $prow->prices['discountedPriceWithoutTax'] != $prow->prices['priceWithoutTax']) {
							echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE) . '</span>';
						}

						if ($prow->prices['discountedPriceWithoutTax']) {
							echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
						} else {
							echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
						}
						?>
					</td>
					<td ><?php

								if ($prow->step_order_level)
									$step=$prow->step_order_level;
								else
									$step=1;
								if($step==0)
									$step=1;
								?>
							<div class="input-group">
						      <input type="text"
								   onblur="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								   onclick="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								   onchange="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								   onsubmit="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED')?>');"
								   title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class=" js-recalculate form-control input-sm" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />
						      <div class="input-group-btn">
						        <button type="submit" class="vmicon vm2-add_quantity_cart btn btn-gray btn-sm" name="updatecart.<?php echo $pkey ?>" title="<?php echo  vmText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" ><i class="fa fa-refresh"></i></button>
								<button type="submit" class="vmicon vm2-remove_from_cart btn btn-gray btn-sm" name="delete.<?php echo $pkey ?>" title="<?php echo vmText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" ><i class="fa fa-times"></i></button>
						      </div>
						    </div><!-- /input-group -->
					</td>

					<?php if (VmConfig::get ('show_tax')) { ?>
					<td class="vm-cart-item-tax" ><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity, false, true) . "</span>" ?></td>
					<?php } ?>
					<td class="vm-cart-item-discount" ><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity, false, true) . "</span>" ?></td>
					<td class="vm-cart-item-total">
					<?php //vmdebug('hm',$prow->prices,$this->cart->cartPrices[$pkey]);
					if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span> ';
					}
					elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && !empty($prow->prices['basePriceVariant']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span> ';
					}
					echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?></td>
				</tr>
					<?php
					$i = ($i==1) ? 2 : 1;
				} ?>

				<!-- footer -->
					<?php if (VmConfig::get ('show_tax')) {
						$colspan = 3;
					} else {
						$colspan = 2;
					} ?>
					<tr class="sectiontableentry1">
						<td colspan="4" ><h6><?php echo vmText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?></h6></td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ><?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE) . "</div>" ?></td>
						<?php } ?>
						<td ><?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE) . "</div>" ?></td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->cartPrices, FALSE) ?></td>
					</tr>

					<?php
					if (VmConfig::get ('coupons_enable')) {
						?>
					<tr class="sectiontableentry2 sectionDark">
						<td colspan="4" >
						<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
							echo $this->loadTemplate ('coupon');
						}
						?>

						<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
						<?php
							echo $this->cart->cartData['couponCode'];
							echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
						?>

						</td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> </td>
						<?php } ?>
						<td > </td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?> </td>
						<?php } else { ?>
						<td colspan="6" >&nbsp;</td>
						<?php
						}

						?>
					</tr>
					<?php } ?>


					<?php
					foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
						?>
					<tr class="sectiontableentry<?php echo $i ?> sectionDark">
						<td colspan="4" ><?php echo $rule['calc_name'] ?> </td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ></td>
						<?php } ?>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
					</tr>
						<?php
						if ($i) {
							$i = 1;
						} else {
							$i = 0;
						}
					} ?>

					<?php

					foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
						?>
					<tr class="sectiontableentry<?php echo $i ?> sectionDark">
						<td colspan="4" ><?php echo $rule['calc_name'] ?> </td>
						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
						<?php } ?>
						<td ><?php ?> </td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
					</tr>
						<?php
						if ($i) {
							$i = 1;
						} else {
							$i = 0;
						}
					}

					foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
						?>
					<tr class="sectiontableentry<?php echo $i ?> sectionDark">
						<td colspan="4" ><?php echo   $rule['calc_name'] ?> </td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ></td>

						<?php } ?>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
					</tr>
						<?php
						if ($i) {
							$i = 1;
						} else {
							$i = 0;
						}
					} ?>

					<?php if ( 	VmConfig::get('oncheckout_opc',true) or
						!VmConfig::get('oncheckout_show_steps',false) or
						(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and
							!empty($this->cart->virtuemart_shipmentmethod_id) )
					) { ?>
					<tr class="sectiontableentry1 sectionDark" valign="top">
						<?php if (!$this->cart->automaticSelectedShipment) { ?>
							<td colspan="4" >
								<?php
									echo $this->cart->cartData['shipmentName'].'<br/>';


							if (!empty($this->layoutName) and $this->layoutName == 'default') {
								if (VmConfig::get('oncheckout_opc', 0)) {
									$previouslayout = $this->setLayout('select');
									echo $this->loadTemplate('shipment');
									$this->setLayout($previouslayout);
								} else {
									echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
								}
							} else {
								echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING');
							}
						} else {
						?>
						<td colspan="4" >
							<?php echo $this->cart->cartData['shipmentName']; ?>
						</td>
						<?php } ?>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ><?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE) . "</div>"; ?> </td>
						<?php } ?>
						<td ><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></td>
						<td ><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?> </td>
					</tr>
					<?php } ?>
					<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and
						( 	VmConfig::get('oncheckout_opc',true) or
							!VmConfig::get('oncheckout_show_steps',false) or
							( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id))
						)
					) { ?>
					<tr class="sectiontableentry1 sectionDark"  valign="top">
						<?php if (!$this->cart->automaticSelectedPayment) { ?>
							<td colspan="4" >
								<?php
									echo $this->cart->cartData['paymentName'].'<br/>';

							if (!empty($this->layoutName) && $this->layoutName == 'default') {
								if (VmConfig::get('oncheckout_opc', 0)) {
									$previouslayout = $this->setLayout('select');
									echo $this->loadTemplate('payment');
									$this->setLayout($previouslayout);
								} else {
									echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
								}
							} else {
							echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT');
						} ?> </td>

						</td>
						<?php } else { ?>
						<td colspan="4" ><?php echo $this->cart->cartData['paymentName']; ?> </td>
						<?php } ?>
						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ><?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</div>"; ?> </td>
						<?php } ?>
						<td ><?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?></td>
						<td ><?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </td>
					</tr>
					<?php  } ?>
					<tr class="sectiontableentry2 total sectionDark">
						<td colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td > <?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE) . "</div>" ?> </td>
						<?php } ?>
						<td > <?php echo "<div  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE) . "</div>" ?> </td>
						<td  class="text-bold"><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?></td>
					</tr>
					<?php
					if ($this->totalInPaymentCurrency) {
					?>

					<tr class="sectiontableentry2 sectionDark">
						<td colspan="4" ><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>

						<?php if (VmConfig::get ('show_tax')) { ?>
						<td ></td>
						<?php } ?>
						<td ></td>
						<td class="text-bold"><?php echo $this->totalInPaymentCurrency;   ?></td>
					</tr>
						<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<!-- end box-content -->
</div>
<!-- end featured-box -->
