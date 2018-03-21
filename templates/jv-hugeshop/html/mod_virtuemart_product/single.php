<?php // no direct access
defined('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();

$col = 1;
$cols = 1;
?>
<?php /// Ul li ?>
<div class="VmGroupSingle blk-thmbs-pro <?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<?php if ($headerText) { ?>
	<p class="vmheader"><?php echo $headerText ?></p>
	<?php } ?>
	<?php if ($display_style == "div") { //Slide ?>
		<div class="carouselOwl" data-items="1" data-singleitem="true" data-pagination="false" data-navigation="true">
			<ul class="list-thumbs-pro">
				<?php foreach ($products as $product) { ?>
					<li class="product vmProduct clearfix">
						<div class="thumb-item-img">
							<?php
							if (!empty($product->images[0]) )
							$image = $product->images[0]->displayMediaThumb('class="featuredProductImage" ',false) ;
							else $image = '';
							echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image,array('title' => $product->product_name) );
							$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.
							$product->virtuemart_category_id); ?>
						</div>
						<div class="thumb-item-content">
							<div class="VmGroupSingleTitle text-semi-bold mb-10">
								<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
							</div>
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
							<?php // $product->prices is not set when show_prices in config is unchecked
							if ($show_price and  isset($product->prices)) {
								echo "<div class='product-price mini text-semi-bold  mb-10'>";
								if (!empty($product->prices['basePrice']) && ($product->prices['basePrice'] != $product->prices['salesPrice']) ) echo '<div class="PricebasePrice">'. $currency->createPriceDiv('basePrice','',$product->prices,true).'</div>';
								// 		echo $currency->priceDisplay($product->prices['salesPrice']);
								if (!empty($product->prices['salesPrice'] ) ) echo '<div class="PricesalesPrice">'. $currency->createPriceDiv('salesPrice','',$product->prices,true).'</div>';
								// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
								if (!empty($product->prices['salesPriceWithDiscount']) ) echo '<div class="PricesalesPrice">'.$currency->createPriceDiv('salesPriceWithDiscount','',$product->prices,true).'</div>';
								echo "</div>";
							}	
							?>
							<?php if ($show_addtocart) echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));	?>
							<?php if ($show_addtocart): ?>
							<div class="thumb-act thumb-act-first vmButtons clearfix">
								<div class="jvAddCart">
								<?php if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) { 
									$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
								?>
								<a href="javascript:void(0);" class="btn-call"><i class="huge-phone"></i></a>
								<?php } else { ?>
									<?php 
										$addtoCartButton = '';
										if(!VmConfig::get('use_as_catalog', 0)){
											if($product->orderable) {
												echo '<a href="javascript:void(0);" class="btn-addcart"><i class="huge-basket-loaded"></i></a>';
											} else {
												echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="huge-options"></i></a>';
											}
										}
									?>		
								<?php } ?>
								</div>							
								<?php if(class_exists('jvmLibs')){
								    echo jvmLibs::loadJCompare($product->virtuemart_product_id);
								    echo jvmLibs::loadJWishlist($product->virtuemart_product_id);
								} ?>
								<?php if(class_exists('PlgSystemPopup')){ ?>
									<div class="jvView"><a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="huge-eye"></i></a></div>
								<?php  } ?>	
							</div>	
							<?php endif;?>
						</div>
					</li>
					<!-- end product-->
					<?php
					if ($col == $products_per_row && $products_per_row && $col < $totalProd) {
						if ($cols < $totalProd) {
							echo "	</ul><ul class=\"list-thumbs-pro\">";
						}
						$col = 1;
					} else {
						$col++;
					} 
					$cols++;
					?>
				<?php } ?>
			</ul>
			<!-- end list-thumbs-pro -->
		</div> 
		<!-- end slides -->
	<?php } else { ?>
	<ul class="list-thumbs-pro <?php echo $params->get('moduleclass_sfx'); ?>">
		<?php foreach ($products as $product) { ?>
			<li class="product vmProduct clearfix">
					<div class="thumb-item-img">
						<?php
						if (!empty($product->images[0]) )
						$image = $product->images[0]->displayMediaThumb('class="featuredProductImage" ',false) ;
						else $image = '';
						echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),$image,array('title' => $product->product_name) );
						$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.
						$product->virtuemart_category_id); ?>
					</div>
					<div class="thumb-item-content">
						<div class="VmGroupSingleTitle text-semi-bold mb-10">
							<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>
						</div>
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
						<?php // $product->prices is not set when show_prices in config is unchecked
						if ($show_price and  isset($product->prices)) {
							echo "<div class='product-price mini text-semi-bold  mb-10'>";
							if (!empty($product->prices['basePrice']) && ($product->prices['basePrice'] != $product->prices['salesPrice']) ) echo '<div class="PricebasePrice">'. $currency->createPriceDiv('basePrice','',$product->prices,true).'</div>';
							// 		echo $currency->priceDisplay($product->prices['salesPrice']);
							if (!empty($product->prices['salesPrice'] ) ) echo '<div class="PricesalesPrice">'. $currency->createPriceDiv('salesPrice','',$product->prices,true).'</div>';
							// 		if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
							if (!empty($product->prices['salesPriceWithDiscount']) ) echo '<div class="PricesalesPrice">'.$currency->createPriceDiv('salesPriceWithDiscount','',$product->prices,true).'</div>';
							echo "</div>";
						}	
						?>
						<?php if ($show_addtocart) echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));	?>
						<?php if ($show_addtocart): ?>
						<div class="thumb-act thumb-act-first vmButtons clearfix">
							<div class="jvAddCart">
							<?php if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($product->images[0]) and !$product->images[0]->file_is_downloadable) { 
								$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', FALSE);
							?>
							<a href="javascript:void(0);" class="btn-call"><i class="huge-phone"></i></a>
							<?php } else { ?>
								<?php 
									$addtoCartButton = '';
									if(!VmConfig::get('use_as_catalog', 0)){
										if($product->orderable) {
											echo '<a href="javascript:void(0);" class="btn-addcart"><i class="huge-basket-loaded"></i></a>';
										} else {
											echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" ><i class="huge-options"></i></a>';
										}
									}
								?>		
							<?php } ?>
							</div>							
							<?php if(class_exists('jvmLibs')){
							    echo jvmLibs::loadJCompare($product->virtuemart_product_id);
							    echo jvmLibs::loadJWishlist($product->virtuemart_product_id);
							} ?>
							<?php if(class_exists('PlgSystemPopup')){ ?>
								<div class="jvView"><a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="huge-eye"></i></a></div>
							<?php  } ?>	
						</div>	
						<?php endif;?>
					</div>
			</li>
		<?php } ?>
	</ul>
	<?php } ?>
	<?php if ($footerText) { ?>
		<p class="vmheader"><?php echo $footerText ?></p>
	<?php } ?>
</div>