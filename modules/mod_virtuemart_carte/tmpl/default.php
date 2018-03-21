<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$nmod = str_replace('mod_', '', ModVirtuemartCarteHelper::$_MOD_PREFIX);
?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
    
        <?php if ($show_product_list) :?> 
        <div class="dropdown">
            <span class="view_cart_link " data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                <i class="gala-shopping82"></i>
                <span class="total_products"><?php echo  $data->totalProduct;?> </span>
            </span>
            <div class="top-bar-nav-shop-card dropdown-menu dropdown-menu-right" role="menu">
                <div class="divsubmenu ModuleMiniSidebar mini-sidebar  moduleMiniCart">
                    <div class="vm_cart_products">
                        <div class="vmcontainer">

                            <?php foreach ($data->products as $pkey=>$product):?> 
                            <div class="product_row clearfix shop-card-products">

                                <?php if (isset($product["image"]) && !empty($product["image"])) : ?>
                                    <?php $img = $product["image"]?>
                                    <div class="blogThumbnail">
                                        <form data-miniaction="rcart" method="post">  
                                            <div class="image"><?php echo $img?></div>
                                            <div class="remove_button">
                                                <button class="vmicon vmicon vm2-remove_from_cart" data-icon="&#xe021;">
                                                    <i class="gala-cancel-stroke"></i>
                                                </button>
                                            </div>                                   
                                            <input type='hidden' class="remove" name="quantity[<?php echo $pkey?>]" value="0">
                                            <input type='hidden' name='method' value='updateCart'/> 
                                            <input type='hidden' name='module' value='<?php echo $nmod ?>'/>
                                            <input type='hidden' name='option' value='com_ajax'/>
                                            <input type='hidden' name='format' value='json'/>  
                                        </form>
                                    </div>
                                <?php endif; ?>
                                
                                
                                <div class="ItemBody shop-card-products-features">
                                    <span class="moduleItemTitle product_name"><?php echo  $product['product_name'] ?></span>
                                    <div class="priceWrap">
                                        <span class="quantity value"> <?php echo  $product['quantity'] ?></span> x 
                                        <?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) : ?>
                                            <span class="price" ><span class="subtotal_with_tax value"><?php echo $product['subtotal_with_tax'] ?></span></span>
                                        <?php endif; ?>
                                        <?php if ( !empty($product['customProductData']) ) : ?>
                                            <div class="customProductData"><?php echo $product['customProductData'] ?></div><br>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach;?>                                                                    
                        </div>
                    </div>
                           
                    <div class="module-topcart">
                        <div class="total pull-left">
                            <?php echo $data->billTotal; ?>
                        </div>
                        
                        <div class="show_cart cartProceed">
                            <?php echo  $data->cart_show; ?>
                        </div>
                        
                    </div><!-- end div.module-topcart -->
                                                     
                </div><!-- end div.divsubmenu -->
            </div>
        </div>
        
        <?php endif; ?>
        
	    <div class="payments_signin_button"></div>
        
        <noscript>
        <?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
        </noscript>                                     
</div>

