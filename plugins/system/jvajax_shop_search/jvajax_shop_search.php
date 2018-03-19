<?php
/**
 * @version     1.0.0
 * @package     plg_system_jvajax_shop_search
 * @copyright   Copyright (C) 2014 PHPKungfu. All rights reserved.
 * @license     http://www.gnu.org/licenseses/gpl-2.0.html GNU/GPL or later
 * @author      info@phpkungfu.club <www.phpkungfu.club>
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');

class plgSystemJVAjax_Shop_Search extends JPlugin{
	function plgSystemJVAjax_Shop_Search( &$subject, $params ){
		parent::__construct( $subject, $params );
	}

    public function onAfterInitialise(){
        $input = JFactory::getApplication()->input;
        if($input->get('plugin') == 'jvajax_shop_search'){
            $source = $input->get('source');
            defined('DS') or define('DS', DIRECTORY_SEPARATOR);
            if($source == 'virtuemart'){
                if (!is_file(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php')){
                    echo 'This module can not work without the VirtueMart Component';
                    return;
                }
                if (!class_exists( 'VmConfig' )) require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
                VmConfig::loadConfig ();
                VmConfig::loadJLang('com_virtuemart',true);

                if($input->get('task') == 'search'){
                    return $this->searchVirtueMart();
                }
            }

            if($source == 'hikashop'){
                if(!is_file(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php')){
                    echo 'This module can not work without the Hikashop Component';
                    return;
                };
                require_once(rtrim(JPATH_ADMINISTRATOR,DS).DS.'components'.DS.'com_hikashop'.DS.'helpers'.DS.'helper.php');

                if($input->get('task') == 'search'){
                    return $this->searchHikashop();
                }
            }

            if($input->get('task') == 'getProductImagesFromCart'){
                return $this->getProductImagesFromCart();
            }
        }
    }

    public function searchVirtueMart(){
        $input = JFactory::getApplication()->input;
        $vendorId = $input->getInt('vendorid', 1);
        $name = $input->getString('name','');
        $from = $input->get('from');
        $to = $input->get('to');
        $desc_limit_char = $input->getInt('desc_limit_char', 80);

        $cid = $input->getInt('cid');
        $Itemid = $input->getInt('Itemid');
        if($Itemid) $Itemid = '&Itemid='.(int)$Itemid;
        else $Itemid = '';

        $categoryModel = VmModel::getModel('Category');
        $productModel = VmModel::getModel('Product');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('a.virtuemart_product_id')
            ->from('#__virtuemart_products a')
            ->join('LEFT', '#__virtuemart_products_'.VmConfig::$vmlang.' l ON a.virtuemart_product_id=l.virtuemart_product_id')
            ->join('LEFT', '#__virtuemart_product_prices p ON a.virtuemart_product_id=p.virtuemart_product_id')
            ->where('a.published=1')
            ->where('a.virtuemart_vendor_id='.$vendorId)
            ->order('l.product_name ASC, p.product_price ASC')
            ->group('a.virtuemart_product_id');
        if($name != '') $query->where('l.product_name LIKE '.$db->quote('%'.$name.'%'));
        if($from != '') $query->where('p.product_price >= '.$from);
        if($to != '') $query->where('p.product_price <= '.$to);
        if($cid){
            $categories = array($cid);
            $this->getCategoryRecurse($vendorId, $cid, $categoryModel, $categories);
            $query
                ->join('LEFT', '#__virtuemart_product_categories pc ON pc.virtuemart_product_id = a.virtuemart_product_id')
                ->where('pc.virtuemart_category_id IN ('.implode(',', $categories).')');
        }
        $db->setQuery($query);
        $ids = $db->loadColumn();

        $products = array();
        if($ids){
            $products = $productModel->getProducts($ids);
            $productModel->addImages($products);
            $currency = CurrencyDisplay::getInstance();

            foreach($products as $product){
                if (!empty($product->images[0])){
                    $product->image_url = JURI::base(true).'/'.$product->images[0]->file_url;
                } else {
                    $product->image_url = '';
                }

                $product->product_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id.$Itemid, false);
                $product->product_description = $this->cutString($product->product_s_desc, $desc_limit_char);

                $product->price_formated = '';
                if ($product->prices['salesPrice']<=0 && VmConfig::get ('askprice', 1) && isset($product->images[0]) && !$product->images[0]->file_is_downloadable) {
                    $askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id . '&tmpl=component', false);
                    $product->price_formated = '<a class="ask-a-question bold" href="'.$askquestion_url.'" rel="nofollow" target="_blank" >'.vmText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE').'</a>';
                }elseif (!empty($product->prices['salesPrice'])){
                    $product->price_formated = $currency->createPriceDiv('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
                }elseif (!empty($product->prices['salesPriceWithDiscount'])){
                    $product->price_formated = $currency->createPriceDiv('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
                }
                $product->product_addtocart_html = $this->getAddtocartHtml($product);
            }
        }
        exit(json_encode($products));
    }

    public function searchHikashop(){
        $input = JFactory::getApplication()->input;
        $name = $input->getString('name','');
        $from = $input->get('from');
        $to = $input->get('to');
        $currency = $input->get('currency');
        $cid = $input->getInt('cid');
        $current_url = $input->getString('current_url');
        $desc_limit_char = $input->getInt('desc_limit_char', 80);
        $Itemid = $input->getInt('Itemid');

        if($Itemid) $Itemid = '&Itemid='.(int)$Itemid;
        else $Itemid = '';

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('DISTINCT a.product_id, a.product_name, a.product_alias, a.product_description, p.price_value')
            ->from(hikashop_table('product').' a')
            ->join('LEFT', hikashop_table('price').' p ON p.price_product_id = a.product_id')
            // ->where('p.price_currency_id = '.$currency)
            ->where('a.product_published = 1')
            ->order('a.product_name ASC, p.price_value ASC')
        ;
        if($name != '') $query->where('a.product_name LIKE '.$db->quote('%'.$name.'%'));
        if($from != '') $query->where('p.price_value >= '.$from);
        if($to != '') $query->where('p.price_value <= '.$to);
        if($cid){
            $query->join('LEFT', hikashop_table('product_category').' pc ON pc.product_id = a.product_id')->where('(pc.category_id='.$cid.' OR a.product_manufacturer_id = '.$cid.')');
        }

        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if(!empty($rows)){
            $ids = array();
            foreach($rows as $key => $row){
                $ids[]=$row->product_id;
            }
            $queryImage = 'SELECT file_path, file_ref_id FROM '.hikashop_table('file').' WHERE file_ref_id IN ('.implode(',',$ids).') AND file_type=\'product\' ORDER BY file_ref_id ASC, file_ordering ASC, file_id ASC';
            $db->setQuery($queryImage);
            $images = $db->loadObjectList();

            $config = hikashop_config();
            $imageHelper = hikashop_get('helper.image');
            $imageOptions = array('default' => true,'forcesize'=>$config->get('image_force_size',true),'scale'=>$config->get('image_scale_mode','inside'));
            $currencyHelper = hikashop_get('class.currency');
            $productClass = hikashop_get('class.product');

            foreach($rows as $k=>$row){
                if(!empty($images)){
                    foreach($images as $image){
                        if($row->product_id==$image->file_ref_id){
                            $img = $imageHelper->getThumbnail(@$image->file_path, array('width' => $imageHelper->main_thumbnail_x, 'height' => $imageHelper->main_thumbnail_y), $imageOptions);
                            if($img->success) $rows[$k]->image_url = $img->url;
                            break;
                        }
                    }
                }
                $rows[$k]->price_formated = $currencyHelper->format($rows[$k]->price_value, $currency);
                $rows[$k]->product_description = $this->cutString($rows[$k]->product_description, $desc_limit_char);
                $productClass->addAlias($rows[$k]);
                $rows[$k]->product_link = str_replace('&amp;', '&', hikashop_completeLink('product&task=show&cid='.$rows[$k]->product_id.'&name='.$rows[$k]->alias.$Itemid));


                $url = $config->get('redirect_url_after_add_cart','stay_if_cart');
                switch($url){
                    case 'checkout':
                        $url = hikashop_completeLink('checkout'.$Itemid,false,true);
                        break;
                    case 'stay_if_cart':
                        $url='';
                    case 'ask_user':
                    case 'stay':
                        $url='';
                    case '':
                    default:
                        if(empty($url)){
                            $url = $current_url;
                        }
                        break;
                }

                $rows[$k]->addtocart = array(
                    'form_action' => hikashop_completeLink('product&task=updatecart'),
                    'return_url' => urlencode(base64_encode($url)),
                );
            }
        }
        exit(json_encode($rows));
    }

    public function getCategoryRecurse($vendorId, $cid, $categoryModel, &$arr){
        $categories = $categoryModel->getChildCategoryList($vendorId, $cid, null, null, false) ;
        if($categories) foreach($categories as $cat){
            $arr[] = $cat->virtuemart_category_id;
            $this->getCategoryRecurse($vendorId, $cat->virtuemart_category_id, $categoryModel, $arr);
        }
    }

    public function cutString($str, $limit=80, $endChar='...'){
        if(strlen($str)<=$limit) return $str;
        if(strpos($str," ",$limit) > $limit){
            $new_limit=strpos($str," ",$limit);
            $new_str = substr($str,0,$new_limit).$endChar;
            return $new_str;
        }
        $new_str = substr($str,0,$limit).$endChar;
        return $new_str;
    }

    public function getAddtocartHtml($product) {
        ob_start();
        if (!VmConfig::get ('use_as_catalog', 0)) {
            $stockhandle = VmConfig::get ('stockhandle', 'none');
            if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($product->product_in_stock - $product->product_ordered) < 1) {
                $button_lbl = vmText::_ ('COM_VIRTUEMART_CART_NOTIFY');
                $button_cls = 'notify-button';
                $button_name = 'notifycustomer';
                ?>
                <div style="display:inline-block;">
                    <a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $product->virtuemart_product_id); ?>" class="notify"><?php echo vmText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
                </div>
            <?php
            } else {
                ?>
                <div class="addtocart-area">

                    <form method="post" class="product" action="index.php">
                        <?php
                        // Product custom_fields
                        if (!empty($product->customfieldsCart)) {
                            ?>
                            <div class="product-fields">
                                <?php foreach ($product->customfieldsCart as $field) { ?>

                                    <div style="display:inline-block;" class="product-field product-field-type-<?php echo $field->field_type ?>">
                                        <?php if($field->show_title == 1) { ?>
                                            <span class="product-fields-title"><b><?php echo $field->custom_title ?></b></span>
                                            <?php echo JHTML::tooltip ($field->custom_tip, $field->custom_title, 'tooltip.png'); ?>
                                        <?php } ?>
                                        <span class="product-field-display"><?php echo $field->display ?></span>
                                        <span class="product-field-desc"><?php echo $field->custom_desc ?></span>
                                    </div>

                                <?php } ?>
                            </div>
                        <?php } ?>

                        <div class="addtocart-bar">

                            <?php
                            // Display the quantity box
                            ?>
                            <!-- <label for="quantity<?php echo $product->virtuemart_product_id;?>" class="quantity_box"><?php echo vmText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
			<span class="addtocart-controls">
			<input type="button" class="quantity-controls quantity-minus" value="-"/>
			<input type="text" class="quantity-input" name="quantity[]" value="1"/>

			<input type="button" class="quantity-controls quantity-plus" value="+"/>

			</span>


                            <?php
                            // Add the button
                            $button_lbl = vmText::_ ('COM_VIRTUEMART_CART_ADD_TO');
                            $button_cls = ''; //$button_cls = 'addtocart_button';


                            ?>
                            <?php // Display the add to cart button ?>
                            <span class="addtocart-button module-addtocart-button">
							<?php echo shopFunctionsF::getAddToCartButton($product->orderable); ?>
							</span>

                            <div class="clear"></div>
                        </div>

                        <input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
                        <input type="hidden" name="option" value="com_virtuemart"/>
                        <input type="hidden" name="view" value="cart"/>
                        <noscript><input type="hidden" name="task" value="add"/></noscript>
                        <input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
                        <input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>"/>
                    </form>
                    <div class="clear"></div>
                </div>
            <?php
            }
        }
        return ob_get_clean();
    }

    public function getProductImagesFromCart(){
        if (!is_file(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php')){
            echo 'This module can not work without the VirtueMart Component';
            return;
        }
        if (!class_exists( 'VmConfig' )) require_once(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
        VmConfig::loadConfig ();
        VmConfig::loadJLang('com_virtuemart',true);

        if(!class_exists('VirtueMartCart')) require(VMPATH_SITE.DS.'helpers'.DS.'cart.php');
        $cart = VirtueMartCart::getCart(false);
        $products = array();
        if($cart->cartProductsData){
            $productModel = VmModel::getModel('Product');
            $productIds = array();
            foreach($cart->cartProductsData as &$productData){
                $productIds[] = $productData['virtuemart_product_id'];
            }
            $products = $productModel->getProducts($productIds);
            $productModel->addImages($products);
            foreach($products as $product){
                if (!empty($product->images[0])) {
                    $product->imageHtml = $product->images[0]->displayMediaThumb ('', FALSE);
                }
            }
        }
        exit(json_encode($products));
    }
}