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
     <div class="vmProduct deal-2">
        <div class="row">
            <div class="col-sm-6 text-center">
                <img src="<?php echo $product->images[0]->file_url; ?>" alt="$product->product_name">
            </div>
            <div class="col-sm-6">
                <?php require JModuleHelper::getLayoutPath('mod_virtuemart_deals', $params->get('layout', 'default') . '_timer'); ?>
                <hr />
                <h3><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h3>
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
                <div class="vm3pr-prices"> <?php
                    echo shopFunctionsF::renderVmSubLayout('prices_mini',array('product'=>$product,'currency'=>$currency)); ?>
                </div>                    
                <?php echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row])); ?>
            </div>
        </div>
    </div>                  
</div>