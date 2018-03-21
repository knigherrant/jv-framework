<?php
/**
 # com_jvvmhelper - JV VM Helper
 # @version		1.0.0
 # ------------------------------------------------------------------------
 # author    PHPKungfu Solutions Co
 # copyright Copyright (C) 2015 phpkungfu.club. All Rights Reserved.
 # @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL or later.
 # Websites: http://www.phpkungfu.club
 # Technical Support:  http://www.phpkungfu.club/my-tickets.html
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

?>

<?php $document = JFactory::getDocument(); ?>

<div class="vm-wishlist">
  <ul class="vm-wishlist--items">
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
      if(!$product)            continue;
      $count++;

      if (!empty($product->images)) $image = $product->images[0];

      $style = '
        .vm-wishlist--thumbnail'.$product->id.'{
          background:url('.JURI::root() . $image->file_url_thumb.') center center no-repeat ;
        }
      '; 
      $document->addStyleDeclaration($style);
   ?>  
      <li class="vm-wishlist--item">
     
          <div class="jv-remove"> 
            <a class="removeWishlist" data-id="<?php echo $product->virtuemart_product_id; ?>" href="javascript:void(0)" class="vm-wishlist--remove">
              <span class="hidden"><?php echo JText::_('COM_JVVMHELPER_REMOVE');?></span>
            </a>
          </div>
       
        
        <div class="row">
         
            <?php if(jvmLibs::isWish('image')){ ?>
                <div class="vm-wishlist--thumbnail vm-wishlist--thumbnail<?php echo $product->id; ?> vm-wishlist--warrior col-md-4">
                  <?php
						echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
						?>
                </div>
            <?php } ?>
        
          <div class="col-md-offset-4 col-md-8">
              <?php if(jvmLibs::isWish('name')){ ?>
                <h3 class="vm-wishlist--name">
                  <a href="<?php echo $product->link.$ItemidStr; ?>"><?php echo $product->product_name; ?></a>
                </h3>
                <div class="vm-wishlist--sku">
                  <span><?php echo JText::_('COM_JVVMHELPER_PRODUCT_SKU'); ?> : </span>
                  <span><?php echo $product->product_sku; ?></span>
                </div>
              <?php } ?>

              <?php if(jvmLibs::isWish('rating')){ ?>
                <div class="vm-wishlist--rating">
                  <?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating, 'product'=>$product)); ?> 
                </div>
              <?php } ?>
              <div class="vm-wishlist--extrainfo">
                <ul class="vm-wishlist--other">
                  <li class="vm-wishlist--other-outstock">
                    <div><?php echo JText::_('COM_JVVMHELPER_PRODUCT_AVAILABLE'); ?> : </div>
                    <div>
                      <?php echo ($product->product_in_stock < 1)? JText::_('COM_JVVMHELPER_OUT_STOCK') : JText::_('COM_JVVMHELPER_IN_STOCK') . $product->product_in_stock . JText::_('COM_JVVMHELPER_ITEMS'); ?>
                    </div>
                    
                  </li>
                  <li>
                    <div class="row">
                      <div class="col-md-7">
                        <?php if(jvmLibs::isWish('price')){ ?>
                          <?php echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$this->currency)); ?>
                        <?php } ?>
                      </div>
                      <div class="col-md-5">
                        <div class="vm-wishlist--addtocart">
                          <?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product)); ?>
                        </div> 
                      </div>
                    </div>
                  </li>
                 
                </ul>
                       
              </div>


          </div>
      
        </div>
      </li>
  <?php } ?>  
  <?php echo vmJsApi::writeJS(); ?>    
  <?php }else{ ?>
      <li class="vm-wishlist--empty bg-danger"><?php echo JText::_('COM_JVVMHELPER_WISHLIST_EMPTY');?></li>
  <?php } ?>
  </ul>
</div>
