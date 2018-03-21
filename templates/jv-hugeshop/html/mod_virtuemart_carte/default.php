<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$nmod = str_replace('mod_', '', ModVirtuemartCarteHelper::$_MOD_PREFIX);
$js="
//<![CDATA[
jQuery(function($) {
    $('.vmCartExModule .dropdown-menu').on('click', function(event) {
        event.stopPropagation();
    });
});
//]]>
" ;
$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
?>

<div id="vmCartModule" class="vmCartExModule <?php echo $params->get('moduleclass_sfx'); ?>">
<?php if ($show_product_list) :?> 
 <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn view_cart_link view_cart_link_1" data-text="<?php echo JText::_('TPL_MY_CART')?>" data-cart="<?php echo JText::_('TPL_CART')?>">
    <i class="huge-cart"></i>
    <span class="total_products"><?php echo  $data->totalProduct;?></span>
    <span class="cart-label hidden"> <?php echo vmText::_('TPL_ITEMS') ?></span>
    <span class="text-total hidden"><?php echo $data->billTotal; ?></span>
</button>
<div class="dropdown-menu" aria-labelledby="dLabel">
    <div class="moduleMiniCart">
        <ul class="list-Cart">
            <?php if (count($data->products) == 0) : ?>
            <li class="product">
                <span><?php echo vmText::_('COM_VIRTUEMART_EMPTY_CART') ;?></span>
            </li>
             <?php endif; ?>
            <?php foreach ($data->products as $pkey=>$product):?> 
            <li class="product">
                <div class="item">
                    <?php if (isset($product["image"]) && !empty($product["image"])) : ?>
                    <?php $img = $product["image"]?>
                    <div class="item-img">
                        <?php echo $img?>
                        
                    </div>
                    <?php endif; ?>
                    
                    <div class="item-content">
                        <h3 class="mt-0"><?php echo  $product['product_name'] ?></h3>
                        <?php if ( !empty($product['customProductData']) ) : ?>
                            <?php echo $product['customProductData'] ?>
                        <?php endif; ?>
                        <?php if ($show_price and $currencyDisplay->_priceConfig['salesPrice'][0]) : ?>
                            <p class="product-price"><span><?php echo  $product['quantity'] ?> x</span> <ins><?php echo $product['subtotal_with_tax'] ?></ins></p>
                        <?php endif; ?>
                    </div>
                    <form data-miniaction="rcart" method="post">  
                        <button class="vm2-remove_from_cart">
                            <i class="fa fa-times"></i>
                        </button>                               
                        <input type='hidden' class="remove" name="quantity[<?php echo $pkey?>]" value="0">
                        <input type='hidden' name='method' value='updateCart'/> 
                        <input type='hidden' name='module' value='<?php echo $nmod ?>'/>
                        <input type='hidden' name='option' value='com_ajax'/>
                        <input type='hidden' name='format' value='json'/>  
                    </form>
                </div>
            </li>
        <?php endforeach;?>
        </ul>
        <div class="cart-footer">
            <ul class="list-inline cart-subtotals">
                <li class="cart-subtotal"><strong><?php echo $data->billTotal; ?></strong></li>
            </ul>
            <?php echo  $data->cart_show; ?>
        </div>
    </div><!-- end div.divsubmenu -->
</div>

<?php endif; ?>

<div class="payments_signin_button"></div>

<noscript>
<?php echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>                                     
</div>