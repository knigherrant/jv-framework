<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();
$col = 1;
$cols = floor (12 / $products_per_row);
?>
<div class="VmGroup <?php echo $params->get ('moduleclass_sfx') ?> products-<?php echo $products_per_row; ?> style3 twocols">

	<?php if ($headerText) { ?>
	<p class="headerText"><?php echo $headerText ?></p>
	<?php
	}
	if ($display_style == "div") { //Slide
		$cols = floor ( 12 / $products_per_row );
		$per_row_sm = ($products_per_row > 1)?($products_per_row - 1):$products_per_row;
		$cols_sm = 4;
		$per_row_xs = ($per_row_sm > 1)?($per_row_sm - 1):$per_row_sm;
		$cols_xs = 6;
		?>
		<div class="row">
			<div class="multi-slides multi-slides-right carouselOwl" 
				data-singleitem="true"
				data-items="1" 
				data-itemsdesktop="1" 
				data-itemsdesktopsmall="1" 
				data-itemstablet="1" 
				data-itemstabletsmall="1" 
				data-itemsmobile="1" 
				data-pagination="false" 
				data-navigation="true" 
				data-autoheight="true" 
				data-navnexttext="<?php echo JText::_('TPL_PREVIOUS'); ?>" 
				data-navprevtext="<?php echo JText::_('TPL_NEXT'); ?>" 
			>
				<div class="itemPro">
					<?php foreach ($products as $key => $product) : ?>
						<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .	$product->virtuemart_category_id); ?>
						<div class="vmProduct<?php echo ' col-xxs-12 col-xs-'. $cols_xs.' col-sm-'.$cols_sm.' col-md-' . $cols;?>">
							<div class="thumb-item">
								<div class="thumb-item-img">
									<a title="<?php echo $product->product_name ?>" href="<?php echo $url; ?>" class="img-slide">
										<?php 
										if (!empty($product->images[0])) {
											$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage"', FALSE);
										} else {
											$image = '';
										}
										echo $image;
										?>
									</a>
								</div>
								<div class="thumb-item-content">
									<h5 class="thumb-title"><a href="<?php echo $url ?>" title="<?php echo $product->product_name ?>"><?php echo $product->product_name ?></a></h5>
									<div class="rating-vmgird">
										<?php
					                    $ratingModel = VmModel::getModel('ratings');
					                    $showRating = $ratingModel->showRating($product->virtuemart_product_id);
					                    if ($showRating=='true'){
					                        $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
					                        if( !empty($rating)) {
					                          $r = $rating->rating;
					                        } else {
					                          $r = 0;
					                        }
					                        $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
					                        $ratingwidth = ( $r * 100 ) / $maxrating; ?>
					                        <?php  if( !empty($rating)) {  ?>                        
					                              <div title=" <?php echo (vmText::_("COM_VIRTUEMART_RATING_TITLE") . round($rating->rating) . '/' . $maxrating) ?>" class="ratingbox" >
					                                  <div class="stars-orange" style="width:<?php echo $ratingwidth.'%'; ?>"></div>
					                                </div>
					                         <?php } else { ?>
					                            <div class="ratingbox dummy" title="<?php echo vmText::_('COM_VIRTUEMART_UNRATED'); ?>" ></div>
					                        <?php } 
					                    } ?>
									</div>								
									<div class="thumb-prices">
										<?php
										if ($show_price and  isset($product->prices)) {
											echo "<div class='product-price mini'>";
											if (!empty($product->prices['basePrice']) && ($product->prices['basePrice'] != $product->prices['salesPrice']) ) echo '<div class="PricebasePrice">'. $currency->createPriceDiv('basePrice','',$product->prices,true).'</div>';
											// 		echo $currency->priceDisplay($product->prices['salesPrice']);
											if (!empty($product->prices['salesPrice'] ) ) echo '<div class="PricesalesPrice">'. $currency->createPriceDiv('salesPrice','',$product->prices,true).'</div>';
											// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
											if (!empty($product->prices['salesPriceWithDiscount']) ) echo '<div class="PricesalesPrice">'.$currency->createPriceDiv('salesPriceWithDiscount','',$product->prices,true).'</div>';
											echo "</div>";
										}?>
									</div>
									<?php if ($show_addtocart) {
										echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'position' => array('ontop', 'addtocart')));
									} ?>
								</div>
								<div class="thumb-act thumb-act-first vmButtons">
									<?php if ($show_addtocart): ?>
										<div class="jvAddCart">
										<?php if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) { 
											$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
										?>
										<a href="javascript:void(0);" class="btn-call"><i class="huge-phone"></i> <span><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></span></a>
										<?php } else { ?>
											<?php 
												$addtoCartButton = '';
												if(!VmConfig::get('use_as_catalog', 0)){
													if($product->orderable) {
														echo '<a href="javascript:void(0);" class="btn-addcart"><i class="huge-basket-loaded"></i> <span>'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'</span></a>';
													} else {
														echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="huge-options"></i> <span>'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</span></a>';
													}
												}
											?>		
										<?php } ?>
										</div>		
									<?php endif; ?>					
									<?php if(class_exists('jvmLibs')){
									    echo jvmLibs::loadJCompare($product->virtuemart_product_id);
									    echo jvmLibs::loadJWishlist($product->virtuemart_product_id);
									} ?>
									<?php if(class_exists('PlgSystemPopup')){ ?>
										<div class="jvView"><a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="huge-eye"></i></a></div>
									<?php  } ?>		
								</div>
							</div>
						</div>
						<?php if ( (($key+1)%($products_per_row * 2) == 0) && (($key+1) < count($products)) )  { ?>
							</div>
							<div class="itemPro abc">
						<?php } ?>
					<?php endforeach; ?>
				</div>
				<!-- end Item Pro -->
			</div>
		</div>
		<?php
	} else { // grid

		// Calculating Products Per Row
		$cols = floor ( 12 / $products_per_row );
		$per_row_sm = ($products_per_row > 1)?($products_per_row - 1):$products_per_row;
		$cols_sm = 3;
		$per_row_xs = ($per_row_sm > 1)?($per_row_sm - 1):$per_row_sm;
		$cols_xs = 6;
		?>
		<div class="row">
			<?php foreach ($products as $product) : ?>
			<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .	$product->virtuemart_category_id); ?>
			<div class="vmProduct<?php echo ' col-xxs-12 col-xs-'. $cols_xs.' col-sm-'.$cols_sm.' col-md-' . $cols;?>"> 
				<div class="thumb-item">
					<div class="thumb-item-img">
						<a title="<?php echo $product->product_name ?>" href="<?php echo $url; ?>" class="img-slide">
							<?php 
							if (!empty($product->images[0])) {
								$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage"', FALSE);
							} else {
								$image = '';
							}
							echo $image;
							?>
						</a>
					</div>
					<div class="thumb-item-content">
						<h5 class="thumb-title"><a href="<?php echo $url ?>" title="<?php echo $product->product_name ?>"><?php echo $product->product_name ?></a></h5>
						<div class="rating-vmgird">
							<?php
		                    $ratingModel = VmModel::getModel('ratings');
		                    $showRating = $ratingModel->showRating($product->virtuemart_product_id);
		                    if ($showRating=='true'){
		                        $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
		                        if( !empty($rating)) {
		                          $r = $rating->rating;
		                        } else {
		                          $r = 0;
		                        }
		                        $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
		                        $ratingwidth = ( $r * 100 ) / $maxrating; ?>
		                        <?php  if( !empty($rating)) {  ?>                        
		                              <div title=" <?php echo (vmText::_("COM_VIRTUEMART_RATING_TITLE") . round($rating->rating) . '/' . $maxrating) ?>" class="ratingbox" >
		                                  <div class="stars-orange" style="width:<?php echo $ratingwidth.'%'; ?>"></div>
		                                </div>
		                         <?php } else { ?>
		                            <div class="ratingbox dummy" title="<?php echo vmText::_('COM_VIRTUEMART_UNRATED'); ?>" ></div>
		                        <?php } 
		                    } ?>
						</div>								
						<div class="thumb-prices">
							<?php
							if ($show_price and  isset($product->prices)) {
								echo "<div class='product-price mini'>";
								if (!empty($product->prices['basePrice']) && ($product->prices['basePrice'] != $product->prices['salesPrice']) ) echo '<div class="PricebasePrice">'. $currency->createPriceDiv('basePrice','',$product->prices,true).'</div>';
								// 		echo $currency->priceDisplay($product->prices['salesPrice']);
								if (!empty($product->prices['salesPrice'] ) ) echo '<div class="PricesalesPrice">'. $currency->createPriceDiv('salesPrice','',$product->prices,true).'</div>';
								// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
								if (!empty($product->prices['salesPriceWithDiscount']) ) echo '<div class="PricesalesPrice">'.$currency->createPriceDiv('salesPriceWithDiscount','',$product->prices,true).'</div>';
								echo "</div>";
							}?>
						</div>
						<?php if ($show_addtocart) {
							echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'position' => array('ontop', 'addtocart')));
						} ?>
					</div>
					<div class="thumb-act thumb-act-first vmButtons">
						<?php if ($show_addtocart): ?>
							<div class="jvAddCart">
							<?php if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) { 
								$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
							?>
							<a href="javascript:void(0);" class="btn-call"><i class="huge-phone"></i> <span><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></span></a>
							<?php } else { ?>
								<?php 
									$addtoCartButton = '';
									if(!VmConfig::get('use_as_catalog', 0)){
										if($product->orderable) {
											echo '<a href="javascript:void(0);" class="btn-addcart"><i class="huge-basket-loaded"></i> <span>'.vmText::_( 'COM_VIRTUEMART_CART_ADD_TO' ).'</span></a>';
										} else {
											echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="huge-options"></i> <span>'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</span></a>';
										}
									}
								?>		
							<?php } ?>
							</div>		
						<?php endif; ?>						
						<?php if(class_exists('jvmLibs')){
						    echo jvmLibs::loadJCompare($product->virtuemart_product_id);
						    echo jvmLibs::loadJWishlist($product->virtuemart_product_id);
						} ?>
						<?php if(class_exists('PlgSystemPopup')){ ?>
							<div class="jvView"><a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="huge-eye"></i></a></div>
						<?php  } ?>		
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
	if ($footerText) : ?>
	<p>
		<?php echo $footerText ?>
	</p>
	<?php endif; ?>
</div>