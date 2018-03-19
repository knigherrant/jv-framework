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

<div class="productdetails-view productdetails pd-content">
	<div class="row">
		<div class="col-sm-6 imagesProduct">
			<?php
			echo $this->loadTemplate('images');
			?>
			<?php
			$count_images = count ($this->product->images);
			if ($count_images > 1) {
				echo $this->loadTemplate('images_additional');
			} ?>
		</div>
		<div class="col-sm-6">
			<div class="thumb-item thumb-item-list summary">
				<div class="thumb-item-content">
					<?php
					// Product Navigation
					if (VmConfig::get('product_navigation', 1)) {
					?>
					<div class="pNeighbours clearfix">
						<?php
						if (!empty($this->product->neighbours ['previous'][0])) {
						$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
						echo JHtml::_('link', $prev_link, '<i class="fa fa-angle-left"></i>', array('rel'=>'prev', 'class' => 'previous-page pull-left','data-dynamic-update' => '1'));
						}
						if (!empty($this->product->neighbours ['next'][0])) {
						$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
						echo JHtml::_('link', $next_link, '<i class="fa fa-angle-right"></i>', array('rel'=>'next','class' => 'next-page pull-right','data-dynamic-update' => '1'));
						}
						?>
					</div>
					<?php } // Product Navigation END?>
					<h4 class="details-title text-uppercase text-semi-bold">
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
					</h4>
					<?php echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$this->product,'currency'=>$this->currency)); ?>
					<div class="review clearfix">
						<ul class="list-review list-unstyled">
							<?php if ($this->showRating) { ?>
							<li>
								<?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating,'product'=>$this->product)); ?>
							</li>
							<?php }?>							
							<li>
								<?php
									$ratingsModel = VmModel::getModel ('ratings');
									$rating_reviews = $ratingsModel->getReviewsByProduct($this->product->virtuemart_product_id);
									$reviews = count($rating_reviews);
								?>(
								<?php echo $reviews.' '; echo ($reviews > 0)?JText::_('TPL_REVIEW_S'):JText::_('TPL_REVIEW')?>)

							</li>
						</ul>
					</div>
					
					<?php
				    // Product Short Description
				    if (!empty($this->product->product_s_desc)) {
					?>
				        <div class="short-desc">
					    <?php
					    /** @todo Test if content plugins modify the product description */
					    echo nl2br($this->product->product_s_desc);
					    ?>
				        </div>
					<?php
				    } // Product Short Description END

					// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
					/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
					  $text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
					  echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
					 */
					?>

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

					echo shopFunctionsF::renderVmSubLayout('addtocart_detail',array('product'=>$this->product));
				    // Ask a question about this product
					if (VmConfig::get('ask_question', 0) == 1) {
						$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
						?>
						<div class="ask-a-question">
							<a class="ask-a-question" href="<?php echo $askquestion_url ?>" rel="nofollow" ><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
						</div>
					<?php
					}?>

					<div class="product-info-wrap">
						<?php if (!empty($this->product->product_sku)) {?>
				    	<p class="product-info"><span><?php echo vmText::_('TPL_SKU')?>:</span> <?php echo $this->product->product_sku;?></p>	
					    <?php }?>					    
						<p class="product-info">
							<span><?php echo vmText::_('COM_VIRTUEMART_CATEGORY')?>: </span>
							<?php
							$cats = array();
							foreach($this->product->categoryItem as $category) {
								//Link to products
								$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$category['virtuemart_category_id'], FALSE);
								$categoryName = $category['category_name'];
								$cats[] = '<a href='.$catURL.' title="'.$categoryName.'">'.$categoryName.'</a>';
							}
							echo implode(', ',$cats);
							?>
						</p>
						<p class="product-info">
							<?php 
							if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
								echo '<span>'.JText::_('TPL_MANUFACTURERS') . ":</span> ";
							    echo $this->loadTemplate('manufacturer');
							}
							?>
						</p>
					</div>
					<?php
					echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
					?>

					<?php // Product Packaging
				    $product_packaging = '';
				    if ($this->product->product_box) {
					?>
				        <p class="product-info">
					    <?php
					        echo '<span>'.vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX').'</span> '.$this->product->product_box;
					    ?>
				    <?php } // Product Packaging END ?>

					<ul class="social-icons-share list-unstyled clearfix">
						
						<?php
						if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
						?>
							<?php $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id; ?>
							<?php
							if (VmConfig::get('pdf_icon')) {
							?>
								<li><a href="<?php echo $link . '&format=pdf';?>" target="_blank"><i class="fa fa-file-pdf-o"></i> <?php echo vmText::_('COM_VIRTUEMART_PDF'); ?></a></li>
							<?php } ?>
							<?php
							if (VmConfig::get('show_printicon')) {
							?>
								<li><a href="<?php echo $link . '&print=1';?>" class="link-modal" ><i class="fa fa-print"></i> <?php echo vmText::_('COM_VIRTUEMART_PRINT'); ?></a></li>
							<?php } ?>
							<?php
							if (VmConfig::get('show_emailfriend')) {
							?>
							<?php $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component'; ?>
							<li><a href="<?php echo $MailLink;?>" class="link-modal"><i class="fa fa-envelope-o"></i> <?php echo vmText::_('TPL_EMAIL_TO_FRIEND'); ?></a></li>
							<?php } ?>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php // End row ?>
	
	<?php // Begin Tab ?>
	<div class="tabs default mt-50">
		<ul class="nav nav-tabs  clearfix">
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
				<?php if (!empty($this->product->product_desc)){
					echo $this->product->event->beforeDisplayContent;
					JPluginHelper::importPlugin('content');
					$desc = JHtml::_('content.prepare', $this->product->product_desc, '', 'com_virtuemart.content');
					echo $desc;			
					echo $this->product->event->afterDisplayContent;
				} ?>
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
	// Show child categories
	if (VmConfig::get('showCategory', 1)) {
		echo $this->loadTemplate('showcategory');
	}

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




