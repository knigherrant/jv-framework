<?php
/**
 * com_jvvmhelper - JV VM Helper
 * @version		1.0.0
 * ------------------------------------------------------------------------
 * author    PHPKungfu Solutions Co
 * copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 * @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 * Websites: http://www.phpkungfu.club
 * Technical Support:  http://www.phpkungfu.club/my-tickets.html
*/

// no direct access
defined('_JEXEC') or die;

?>

<?php $document = JFactory::getDocument(); ?>

<div class="vm-wishlist">
  <ul class="vm-wishlist-items">
  <?php if( $this->items ) { 
    $config = jvmLibs::getConfig();
	$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}
  ?>
  <?php 
      $count=0;
      foreach ($this->items as $product){ 
      $count++;

      if (!empty($product->images)) $image = $product->images[0];
   ?>  
      <li class="vm-wishlist--item">
     
          <div class="jv-remove"> 
            <a class="removeWishlist" data-id="<?php echo $product->virtuemart_product_id; ?>" href="javascript:void(0)">
              <span class="hidden"><?php echo JText::_('COM_JVVMHELPER_REMOVE');?></span>
            </a>
          </div>
        <div class="row">
          <?php if(jvmLibs::isWish('image')){ ?>
              <div class="vm-wishlist-thumbnail vm-wishlist-thumbnail<?php echo $product->id; ?> vm-wishlist-warrior col-xs-6 col-xs-offset-3 mb-sm-30 col-sm-offset-0 col-sm-2 col-md-3 col-lg-2">
                <?php
    						echo $product->images[0]->displayMediaThumb('class=""', false);
    						?>
              </div>
          <?php } ?>
        
          <div class="col-xs-12 <?php echo (jvmLibs::isWish('image'))?'col-sm-10 col-md-9 col-lg-10':'';  ?>">
              <?php if(jvmLibs::isWish('name')){ ?>
                <h4 class="vm-wishlist-name text-semi-bold">
                  <a href="<?php echo $product->link.$ItemidStr; ?>"><?php echo $product->product_name; ?></a>
                </h4>
                <div class="vm-wishlist--sku">
                  <span><?php echo JText::_('COM_JVVMHELPER_PRODUCT_SKU'); ?> : </span>
                  <span><?php echo $product->product_sku; ?></span>
                </div>
              <?php } ?>

              <?php if(jvmLibs::isWish('rating')){ ?>
                <div class="vm-wishlist-rating">
                  <?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating, 'product'=>$product)); ?> 
                </div>
              <?php } ?>
              <div class="vm-wishlist-extrainfo">
                <?php if ( VmConfig::get ('display_stock', 1)) { ?>
                  <div class="outstock"><?php echo JText::_('COM_JVVMHELPER_PRODUCT_AVAILABLE'); ?> : 
                      <?php echo ($product->product_in_stock < 1)? JText::_('COM_JVVMHELPER_OUT_STOCK') : JText::_('COM_JVVMHELPER_IN_STOCK') . $product->product_in_stock . ' ' . JText::_('COM_JVVMHELPER_ITEMS'); ?>
                  </div>
                <?php }?>

                <?php if(jvmLibs::isWish('price')){ ?>
                  <?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$this->currency)); ?>
                <?php } ?>
                <p class="vm-wishlist-desc hidden-xs hidden-sm"><?php echo $product->product_s_desc; ?></p>
                <?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product)); ?>   
              </div>
          </div>
      
        </div>
      </li>
  <?php } ?>  
  <?php echo vmJsApi::writeJS(); ?>    
  <?php }else{ ?>
      <li class="vm-wishlist-empty">      
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <i class="fa fa-heart-o"></i> &nbsp; <?php echo JText::_('COM_JVVMHELPER_WISHLIST_EMPTY');?>
        </div>
      </li>

  <?php } ?>
  </ul>
</div>
