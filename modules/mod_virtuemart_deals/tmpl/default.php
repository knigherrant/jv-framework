<?php // no direct access
    error_reporting('E_ALL');
    defined('_JEXEC') or die('Restricted access');

    $pwidth= ' width100';
    $float="center";
    if (isset($product->step_order_level))
        $step=$product->step_order_level;
    else
        $step=1;
    if($step==0) $step=1;

    $alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
    $discont = $product->prices[discountAmount];
    $discont = abs($discont);
    $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
?>
<div class="items">
     <div class="vmProduct">
        <div class="thumb-item">
            <div class="thumb-item-img">
                <a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">
                    <?php
                    echo $product->images[0]->displayMediaThumb('class="browseProductImage"', false);
                    ?>
                </a>
                <span class="thumb-act thumb-act-first vmButtons">
                    <?php if ($show_addtocart) {?>
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
                                            echo '<a href="'.$product->link.$ItemidStr.'" class="addtocart-button-disabled" title="'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'" >'.vmText::_( 'COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT' ).'</a>';
                                        }
                                    }
                                ?>      
                            <?php } ?>
                        <?php } ?>
                        <?php if(class_exists('PlgSystemPopup')){ ?>
                            <a href="javascript:void(0);" class="btn-popup" title="<?php echo vmText::_( 'TPL_QUICKVIEW' );?>" data-id="<?php echo $product->virtuemart_product_id ?>"><i class="fa fa-search"></i></a>
                        <?php  } ?>     
                </span>
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
                    <h3><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h3>
                    <?php if ( VmConfig::get ('display_stock', 1)) { ?>
                    <span class="vmStock vm2-<?php echo $product->stock->stock_level ?>" title="<?php echo $product->stock->stock_tip ?>"></span>
                    <?php }?>
                    <div class="vm3pr-prices"> <?php
                        echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$product,'currency'=>$currency)); ?>
                    </div>
                    <div class="list-content hidden">
                        <div class="rating-vmgird">
                            <?php echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product)); ?>
                        </div>
                        <div class="product_s_desc">
                            <?php // Product Short Description
                            if (!empty($product->product_s_desc)) {
                                echo shopFunctionsF::limitStringByWord ($product->product_s_desc, 350, ' ...') ?>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row])); ?>
                </div>
        </div>
        <?php require JModuleHelper::getLayoutPath('mod_virtuemart_deals', $params->get('layout', 'default') . '_timer'); ?>
    </div>                  
</div>