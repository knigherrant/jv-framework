<?php // no direct access
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();


$col = 1;
$cols_xs = $cols_sm = $cols = floor (12 / $products_per_row);
if ($products_per_row > 2) {
	$cols_sm = floor (12 / ($products_per_row - 1));
	$cols_xs = floor (12 / ($products_per_row - 2));
}
?>
<div class="VmGroup style-3 <?php echo $params->get ('moduleclass_sfx') ?>">

	<?php if ($headerText) { ?>
	<p class="headerText"><?php echo $headerText ?></p>
	<?php
	}
	if ($display_style == "div") { //Slide
		?>
		<div class="row">
			<div class="multi-slides multi-slides-right carouselOwl" 
				data-items="<?php echo $products_per_row ?>" 
				data-itemsdesktop="<?php echo $products_per_row ?>" 
				data-itemsdesktopsmall="<?php echo ($products_per_row - 1) ?>" 
				data-itemstablet="3"  
				data-itemstabletsmall = "2" 
				data-itemsmobile = "1" 
				data-pagination="false" 
				data-navigation="true"
			>
				<?php foreach ($products as $product) : ?>
				<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .	$product->virtuemart_category_id); ?>
				<div class="vmProduct col-xs-12">
					<input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 
					<div class="thumb-item">
						<div class="thumb-item-img">
							<a title="<?php echo $product->product_name ?>" href="<?php echo $url; ?>" class="btn-detail">
								<?php
								echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
								?>
							</a>
							<div class="thumb-act thumb-act-first vmButtons">
								<div class="divtable">
									<div class="divtablecell">
										<div>
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
															echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" >'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</a>';
														}
													}
												?>		
											<?php } ?>
										</div>
										<?php if(class_exists('PlgSystemPopup')){ ?>
											<div>
												<a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><?php echo vmText::_( 'TPL_QUICKVIEW' );?></a>
											</div>
										<?php  } ?>						
										<?php if(class_exists('jvmLibs')){ ?>
											<div>
										    <?php echo jvmLibs::loadJCompare($product->virtuemart_product_id); ?>
										    </div>
										    <div>
										    <?php echo jvmLibs::loadJWishlist($product->virtuemart_product_id); ?>
										    </div>
										<?php } ?>	
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="thumb-item-content">
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
						<h3><a href="<?php echo $url ?>" title="<?php echo $product->product_name ?>"><?php echo $product->product_name ?></a></h3>
						<?php
						if ($show_price and  isset($product->prices)) { ?>
							<div class="vm3pr-prices"> <?php
							echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$product,'currency'=>$currency)); ?>
						</div>
						<?php }	
						if ($show_addtocart) {
							echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'position' => array('ontop', 'addtocart')));
						}
						?>
					</div>
				</div>
				
			<?php endforeach; ?>
			</div>
		</div>
		<?php
	} else { // grid
		$last = count ($products) - 1;
		?>
		<div class="row list-unstyled">
			<?php foreach ($products as $product) : ?>
				<?php $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .	$product->virtuemart_category_id); ?>
			<div class="vmProduct col-xs-<?php echo $cols_xs?> col-sm-<?php echo $cols_sm?> col-md-<?php echo $cols?>">
				<div class="thumb-item">
					<div class="thumb-item-img">
						<a title="<?php echo $product->product_name ?>" href="<?php echo $url; ?>" class="btn-detail">
							<?php
							echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
							?>
						</a>
						<div class="thumb-act thumb-act-first vmButtons">
							<div class="divtable">
								<div class="divtablecell">
									<div>
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
														echo '<a href="'.$url.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" >'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</a>';
													}
												}
											?>		
										<?php } ?>
									</div>
									<?php if(class_exists('PlgSystemPopup')){ ?>
										<div>
											<a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><?php echo vmText::_( 'TPL_QUICKVIEW' );?></a>
										</div>
									<?php  } ?>						
									<?php if(class_exists('jvmLibs')){ ?>
										<div>
									    <?php echo jvmLibs::loadJCompare($product->virtuemart_product_id); ?>
									    </div>
									    <div>
									    <?php echo jvmLibs::loadJWishlist($product->virtuemart_product_id); ?>
									    </div>
									<?php } ?>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="thumb-item-content">
						<h3><a href="<?php echo $url ?>" title="<?php echo $product->product_name ?>"><?php echo $product->product_name ?></a></h3>
						<?php
						if ($show_price and  isset($product->prices)) { ?>
							<div class="vm3pr-prices"> <?php
							echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$product,'currency'=>$currency)); ?>
						</div>
						<?php }	
						if ($show_addtocart) {
							echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'position' => array('ontop', 'addtocart')));
						}
						?>
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
					</div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $last) {
				$col = 1;
			} else {
				$col++;
			}
			$last--;
		endforeach; ?>
		</div>
		<?php
	}
	if ($footerText) : ?>
	<p>
		<?php echo $footerText ?>
	</p>
	<?php endif; ?>
</div>