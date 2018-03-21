<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz, Max Galt
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));


if(vRequest::getInt('print',false)){ ?>
<body onload="javascript:print();">
<?php } ?>

<div class="productdetails-view productdetails">
	<div class="row">
		<div class="col-md-5 col-lg-6 imagesProduct mb-sm-60">			
				<?php
				$count_images = count ($this->product->images);
				if ($count_images > 1) {?>
					<div class="row">
						<div class="col-xs-2">
							<?php echo $this->loadTemplate('images_additional'); ?>
						</div>
						<div class="col-xs-10">
				<?php } ?>
							<?php
							echo $this->loadTemplate('images');
							?>
				<?php if ($count_images > 1) {?>
						</div>
					</div>
					<?php echo $this->loadTemplate('images_additionalbottom'); ?>
				<?php } ?>		
		</div>
		<div class="col-md-7 col-lg-6">
			<div class="summaryProduct">
				<div class="summaryProduct-content">
					<?php
					// Product Navigation
					if (VmConfig::get('product_navigation', 1)) {
					?>
					<div class="pNeighbours clearfix">
						<?php
						if (!empty($this->product->neighbours ['previous'][0])) {
						$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
						echo JHtml::_('link', $prev_link, '<i class="fa fa-long-arrow-left"></i>', array('rel'=>'prev', 'class' => 'previous-page pull-left','data-dynamic-update' => '1'));
						}
						if (!empty($this->product->neighbours ['next'][0])) {
						$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
						echo JHtml::_('link', $next_link, '<i class="fa fa-long-arrow-right"></i>', array('rel'=>'next','class' => 'next-page pull-right','data-dynamic-update' => '1'));
						}
						?>
					</div>
					<?php } // Product Navigation END?>
					<h2 class="details-title">
						<?php echo $this->product->product_name ?>
						<?php if ( !empty($this->product->event->afterDisplayTitle) || !empty($this->edit_link) ) { ?>
						<sup>
							<small>
								<?php
							    echo $this->product->event->afterDisplayTitle ?>
							    <?php
							    echo $this->edit_link;
							    ?>
							</small>
						</sup>
						<?php }?>
					</h2>
					<div class="review-price clearfix">
						<ul class="list-review list-unstyled">
							<?php if ($this->showRating) { ?>
							<li>
								<?php echo shopFunctionsF::renderVmSubLayout('rating_detail',array('showRating'=>$this->showRating,'product'=>$this->product)); ?>
							</li>
							<?php }?>
							<li class='ml-40'>
								<?php
									$ratingsModel = VmModel::getModel ('ratings');
									$rating_reviews = $ratingsModel->getReviewsByProduct($this->product->virtuemart_product_id);
									$reviews = count($rating_reviews);
								?>
								<?php echo $reviews.' '; echo ($reviews > 0)?JText::_('TPL_REVIEW_S'):JText::_('TPL_REVIEW')?>

							</li>
						</ul>
					</div>
					<?php
						echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
					?>
					<?php if (!empty($this->product->product_sku)) {?>
				    	<div class="summary-sku"><span><?php echo vmText::_('TPL_PRODUCT_CODE')?> </span> <span><?php echo $this->product->product_sku;?></span></div>	
				    <?php  }?>

					<?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$this->product,'currency'=>$this->currency)); ?>

					<?php
				    // Product Short Description
				    if (!empty($this->product->product_s_desc)) {
					?>
				        <div class="summary-description">
						    <?php
						    /** @todo Test if content plugins modify the product description */
						    echo nl2br($this->product->product_s_desc);
						    ?>
				        </div>
					<?php
				    } // Product Short Description END
				    ?>
					
					<?php
					// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
					/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
					  $text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
					  echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
					 */
					?>
					<?php if ( (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) || ($this->product->product_box)) { ?>
					<div class="summaryDetail">
						<div class="row">
							<div class="col-lg-10">
								<?php 
								if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
									echo '<div class="product-info"><span>'.JText::_('TPL_MANUFACTURERS') . ":</span></div>";
								    echo $this->loadTemplate('manufacturer');
								}
								?>
								<?php // Product Packaging
							    $product_packaging = '';
							    if ($this->product->product_box) {
								?>
							        <div class="product-info">
								    <?php
								        echo '<span>'.vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX').'</span> '.$this->product->product_box;
								    ?>
								    </div>
								<?php } // Product Packaging END ?>
							</div>
						</div>
					</div>				
					<?php } ?>
				    <?php
					if (is_array($this->productDisplayShipments)) {
					    foreach ($this->productDisplayShipments as $productDisplayShipment) {
						echo $productDisplayShipment;
						if ($productDisplayShipment) {
							echo '<br />';
						}
					    }
					}
					if (is_array($this->productDisplayPayments)) {
					    foreach ($this->productDisplayPayments as $productDisplayPayment) {
							echo $productDisplayPayment;
							if ($productDisplayPayment) {
								echo '<br />';
							}
					    }
					}
					echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'ontop'));

					echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$this->product));
				    ?>
					

					<div class="social-icons-share list-unstyled clearfix">
						<?php
						if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
						?>
							<label class="block mb-20"><?php echo JText::_('TPL_SHARE_ON')?>:</label>
							<?php
								jimport('joomla.application.module.helper');
								$modules = JModuleHelper::getModules('product-social'); 
								foreach($modules as $module)
								{
									echo '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-550f8d37549a1fcb" async="async"></script>'.JModuleHelper::renderModule($module);
								}
						  	?>
							<?php $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id; ?>
							<?php
							if (VmConfig::get('pdf_icon')) {
							?>
								<div><a href="<?php echo $link . '&format=pdf';?>" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo vmText::_('COM_VIRTUEMART_PDF'); ?>"><i class="fa fa-file-pdf-o"></i></a></div>
							<?php } ?>
							<?php
							if (VmConfig::get('show_printicon')) {
							?>
								<div><a href="<?php echo $link . '&print=1';?>" class="link-modal" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo vmText::_('COM_VIRTUEMART_PRINT'); ?>"><i class="fa fa-print"></i></a></div>
							<?php } ?>
							<?php
							if (VmConfig::get('show_emailfriend')) {
							?>
							<?php $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component'; ?>
								<div><a href="<?php echo $MailLink;?>" class="link-modal" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo vmText::_('COM_VIRTUEMART_EMAIL'); ?>"><i class="fa fa-envelope-o"></i></a></div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php // End row ?>
	
	<?php // Begin Tab ?>
	<div class="tabs tabs-9 mt-70">
		<ul class="nav nav-tabs clearfix">
			<?php if (!empty($this->product->product_desc)) { ?>
		        <li class="active">
		        	<a href="#description" data-toggle="tab"><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE') ?></a>
		        </li>
		    <?php } ?>
			<?php if ($this->allowRating || $this->allowReview || $this->showRating || $this->showReview) { ?>
			<li class="<?php echo (empty($this->product->product_desc))?"active":""?>">
	        	<?php
	        		$ratingsModel = VmModel::getModel ('ratings');
					$rating_reviews = $ratingsModel->getReviewsByProduct($this->product->virtuemart_product_id);
					$reviews = count($rating_reviews);
	        	?>
	        	<a href="#review" class="nav-review" data-toggle="tab"><?php echo vmText::_ ('COM_VIRTUEMART_REVIEWS') ?> (<?php echo $reviews;?>)</a>
	        </li>	
	        <?php } ?>        
			<?php if (!empty($this->product->customfieldsSorted['normal'])) { ?>
				<li class="<?php echo (empty($this->product->product_desc) && !($this->allowRating || $this->allowReview || $this->showRating || $this->showReview))?'active':'';?>"><a href="#additional" data-toggle="tab" aria-expanded="true"><?php  echo JText::_( 'TPL_ADDITIONAL' ); ?></a></li>
			<?php } ?>
		</ul>
		<div class="tab-content">
			<?php if (!empty($this->product->product_desc) || !empty($this->product->product_box)) { ?>
			<div class="tab-pane active" id="description">
				<?php if (!empty($this->product->product_desc)){ ?>
				<?php echo $this->product->event->beforeDisplayContent; ?>
				<?php echo $this->product->product_desc; ?>
				<?php echo $this->product->event->afterDisplayContent; ?>
				<?php
				}
				?>
			</div>
			<?php } // Product Description END ?>
			<?php if ($this->allowRating || $this->allowReview || $this->showRating || $this->showReview) { ?>
			<div class="tab-pane<?php echo (empty($this->product->product_desc))?' active':'';?>" id="review">
				<?php echo $this->loadTemplate('reviews');?>
			</div>
			<?php } ?>
			<?php if (!empty($this->product->customfieldsSorted['normal'])) { ?>
			<div class="tab-pane<?php echo (empty($this->product->product_desc) && !($this->allowRating || $this->allowReview || $this->showRating || $this->showReview))?" active":""?>" id="additional">
				<?php echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal')); ?>
			</div>
			<?php } ?>

		</div>
	</div>
	<?php // End Tab ?>

	<?php 
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));
 	echo shopFunctionsF::renderVmSubLayout('customfields_related',array('product'=>$this->product,'position'=>'related_products','class'=> 'related','customTitle' => true ));
	echo shopFunctionsF::renderVmSubLayout('customfields_categories',array('product'=>$this->product,'position'=>'related_categories','class'=> 'related', 'customTitle' => true));
	?>
	<?php
	

$j = 'jQuery(document).ready(function($) {
	Virtuemart.product(jQuery("form.product"));

	$("form.js-recalculate").each(function(){
		if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
			var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
			Virtuemart.setproducttype($(this),id);

		}
	});
});';
//vmJsApi::addJScript('recalcReady',$j);

/** GALT
 * Notice for Template Developers!
 * Templates must set a Virtuemart.container variable as it takes part in
 * dynamic content update.
 * This variable points to a topmost element that holds other content.
 */
$j = "Virtuemart.container = jQuery('.productdetails-view');
Virtuemart.containerSelector = '.productdetails-view';";

vmJsApi::addJScript('ajaxContent',$j);

if(VmConfig::get ('jdynupdate', TRUE)){
	$j = "jQuery(document).ready(function($) {
	Virtuemart.stopVmLoading();
	var msg = '';
	jQuery('a[data-dynamic-update=\"1\"]').off('click', Virtuemart.startVmLoading).on('click', {msg:msg}, Virtuemart.startVmLoading);
	jQuery('[data-dynamic-update=\"1\"]').off('change', Virtuemart.startVmLoading).on('change', {msg:msg}, Virtuemart.startVmLoading);
});";

	vmJsApi::addJScript('vmPreloader',$j);
}

echo vmJsApi::writeJS();

if ($this->product->prices['salesPrice'] > 0) {
  echo shopFunctionsF::renderVmSubLayout('snippets',array('product'=>$this->product, 'currency'=>$this->currency, 'showRating'=>$this->showRating));
}

?>
</div> 
<?php ?>




