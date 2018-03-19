<?php
/**
 * @version     1.0.0
 * @package     mod_jvajax_shop_search
 * @copyright   Copyright (C) 2014 PHPKungfu. All rights reserved.
 * @license     http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL or later
 * @author      info@phpkungfu.club <www.phpkungfu.club>
 */

defined('_JEXEC') or die('Restricted access');
?>
<div class="jvajax_shop_search jvajax_shop_search_<?php echo $show_style?> jvajax_shop_search_<?php echo $source?>" id="jvajax_shop_search<?php echo $module->id?>">
    <div class="jvajax_shop_search_fields ">
        <?php if($name_filter){?>
        <div class="jvajax_shop_search_name_block">
            <input type="text" placeholder="<?php echo JText::_('MOD_JVAJAX_SHOP_SEARCH_PRODUCT_NAME'); ?>" data-bind="value: name, valueUpdate: ['input', 'afterkeydown']">
        </div>
        <?php }?>
        <?php if($price_filter){?>
            <?php if($price_style == 'input'){?>
                <div class="jvajax_shop_search_block row">
                    <div class="col-xs-6">
                        <input type="text" placeholder="<?php echo JText::_('MOD_JVAJAX_SHOP_SEARCH_FROM'); ?>" data-bind="numeric: from, value: from, valueUpdate: ['input', 'afterkeydown']">
                    </div>
                    <div class="col-xs-6">
                        <input type="text" placeholder="<?php echo JText::_('MOD_JVAJAX_SHOP_SEARCH_TO'); ?>" data-bind="numeric: to, value: to, valueUpdate: ['input', 'afterkeydown']">
                    </div>
                </div>
            <?php }else{ ?>
                <div class="jvajax_shop_search_price_slider">
                    <input type="text" class="slider" data-bind="sliderValue: {value: priceSlider, min: <?php echo $price_slider_min;?>, max: <?php echo $price_slider_max;?>, step: 1, tooltip_separator: ' - ', range: true}"/>
                </div>
            <?php }?>
        <?php }?>
    </div>
    <div class="jvajax_shop_search_content jvajax_shop_search_loading" data-bind="visible: loading" style="display: none; <?php echo $popup_width?>">
        <img src="<?php echo JUri::root().'modules/mod_jvajax_shop_search/assets/images/loader.gif';?>" alt=""/>
    </div>
    <div class="jvajax_shop_search_content jvajax_shop_search_products_ctn" data-bind="simpleGrid: gridProductsModel, simpleGridTemplate: 'ko_jvajax_shop_search_products<?php echo $module->id?>', simpleGridPagerTemplate: 'ko_jvajax_shop_search_pagination<?php echo $module->id?>', visible: !loading() && products().length" style="display: none; <?php echo $popup_width?>"></div>

    <script type="text/html" id="ko_jvajax_shop_search_products<?php echo $module->id?>">
        <!-- ko if: itemsOnCurrentPage().length>0 -->
        <div class="div_<?php echo $source;?>_products row cols<?php echo $max_cols?>" data-bind="foreach: itemsOnCurrentPage">
            <!-- ko foreach: $parent.columns -->
			<div class="col-sm-<?php echo 12/$max_cols?> col-md-<?php echo 12/$max_cols?>">
                <div class="item">
                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_image() && !JVAjaxShopSearchModel<?php echo $module->id?>.image_pos()-->
                    <a class="image" href="" data-bind="attr: {href: $parent.product_link}, css: JVAjaxShopSearchModel<?php echo $module->id?>.image_align()">
                        <img <?php echo $image_width;?> <?php echo $image_height;?> data-bind="attr: {src: $parent.image_url, alt: $parent.product_name, title: $parent.product_name}">
                    </a>
                    <!-- /ko -->

                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_title()-->
                    <a class="title" data-bind="text: $parent.product_name, attr: {href: $parent.product_link}"></a>
                    <!-- /ko -->

                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_image() && JVAjaxShopSearchModel<?php echo $module->id?>.image_pos()-->
                    <a class="image" href="" data-bind="attr: {href: $parent.product_link}, css: JVAjaxShopSearchModel<?php echo $module->id?>.image_align()">
                        <img <?php echo $image_width;?> <?php echo $image_height;?> data-bind="attr: {src: $parent.image_url, alt: $parent.product_name, title: $parent.product_name}">
                    </a>
                    <!-- /ko -->

                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_desc()-->
                    <div class="short_desc" data-bind="text: $parent.product_description"></div>
                    <!-- /ko -->

                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_price()-->
                    <div class="price" data-bind="html: $parent.price_formated"></div>
                    <!-- /ko -->

                    <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.show_addtocart()-->
                        <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.source() == 'virtuemart'-->
                        <div data-bind="html: $parent.product_addtocart_html"></div>
                        <!-- /ko -->
                        <!-- ko if: JVAjaxShopSearchModel<?php echo $module->id?>.source() == 'hikashop'-->
                        <form  class="form_add_to_cart" method="post" data-bind="attr: {action: $parent.addtocart.form_action}">
                            <div class="hikashop_product_stock">
                                <input type="submit" class="btn button hikashop_cart_input_button" name="add" value="Add to cart">
                                <input type="hidden" value="1" class="hikashop_product_quantity_field" name="quantity">
                            </div>
                            <input type="hidden" name="product_id" value="" data-bind="value: $parent.product_id"/>
                            <input type="hidden" name="add" value="1"/>
                            <input type="hidden" name="ctrl" value="product"/>
                            <input type="hidden" name="task" value="updatecart"/>
                            <input type="hidden" name="return_url" value="" data-bind="value: $parent.addtocart.return_url"/>
                        </form>
                        <!-- /ko -->
                    <!-- /ko -->
                </div>
			</div>
            <!-- /ko -->
        </div>
        <!-- /ko -->
    </script>

    <script type="text/html" id="ko_jvajax_shop_search_pagination<?php echo $module->id?>">
        <div class="ko-grid-pageLinks jvajax_shop_search_products_pagination">
            <!-- ko if: maxPageIndex()>0 -->
            <ul class="pagination-list">
                <span class="pagenav" data-bind="visible: $root.currentPageIndex() == 0"><i class="icon icon-backward3"></i></span>
                <a class="pagenav" href="javascript:void(0)" data-bind="click: $root.gridPrev, visible: $root.currentPageIndex() != 0"><i class="icon icon-backward3"></i></a>

                <!-- ko foreach: ko.utils.range(0, maxPageIndex) -->
                    <span class="pagenav" data-bind="text: $data + 1, visible: $data == $root.currentPageIndex()"></span>
                    <a class="pagenav" href="javascript:void(0)" data-bind="visible: $data != $root.currentPageIndex() && JVAjaxShopSearchModel<?php echo $module->id?>.showPage($root.maxPageIndex(), $root.currentPageIndex(), $data), text: $data + 1, click: function() { $root.currentPageIndex($data) }"></a>
                    <span data-bind="visible: $data != $root.currentPageIndex() && !JVAjaxShopSearchModel<?php echo $module->id?>.showPage($root.maxPageIndex(), $root.currentPageIndex(), $data) && JVAjaxShopSearchModel<?php echo $module->id?>.showPage($root.maxPageIndex(), $root.currentPageIndex(), $data-1)">...</span>
                <!-- /ko -->

                <span data-bind="visible: $root.currentPageIndex() == maxPageIndex()" class="pagenav"><i class="icon icon-forward4"></i></span>
                <a class="pagenav" href="javascript:void(0)" data-bind="click: $root.gridNext, visible: $root.currentPageIndex() != maxPageIndex()"><i class="icon icon-forward4"></i></a>
            </ul>
            <!-- /ko -->
        </div>
    </script>
</div>

<script type="text/javascript">
    $JVAS(function($){
        window.JVAjaxShopSearchModel<?php echo $module->id?> = new JVAjaxShopSearchModel({
            source: '<?php echo $source;?>',
            currency: '<?php echo $currency;?>',
            cid: '<?php echo $cid;?>',
            Itemid: <?php echo $Itemid;?>,
            max_cols: '<?php echo $max_cols;?>',
            max_rows: '<?php echo $max_rows;?>',
            moduleid: <?php echo $module->id?>,
            show_style: '<?php echo $show_style?>',
            show_image: <?php echo $show_image;?>,
            image_pos: <?php echo $image_pos;?>,
            image_align: '<?php echo $image_align;?>',
            show_title: <?php echo $show_title;?>,
            show_price: <?php echo $show_price;?>,
            price_style: '<?php echo $price_style;?>',
            price_slider_min: <?php echo $price_slider_min;?>,
            price_slider_max: <?php echo $price_slider_max;?>,
            show_desc: <?php echo $show_desc;?>,
            desc_limit_char: '<?php echo $desc_limit_char;?>',
            show_addtocart: <?php echo $show_addtocart;?>,
            current_url: '<?php echo JUri::getInstance();?>',
            pagination_position: '<?php echo $pagination_position;?>'
        });
        ko.applyBindings(JVAjaxShopSearchModel<?php echo $module->id?>, document.getElementById('jvajax_shop_search<?php echo $module->id?>'));
    });
</script>