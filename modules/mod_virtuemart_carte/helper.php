<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_users_latest
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_virtuemart_cart
 *
 * @package     Joomla.Site
 * @subpackage  mod_virtuemart_cart
 *
 * @since       1.6
 */
 
 defined('DS') or define('DS', DIRECTORY_SEPARATOR);
 
class ModVirtuemartCarteHelper
{
    static $_MOD_PREFIX = "mod_virtuemart_carte";
    static $_COM_PREFIX = "com_virtuemart";
        
    // Render the code for Ajax Cart
    static function getData($checkAutomaticSelected=true){
       
        // load config VM
        self::loadConfigVM();
        
        // load VM cart
        self::loadVMcart();
        
        $cart = VirtueMartCart::getCart(false);
        $cart->prepareCartData();
        $data = new stdClass();
        $data->products = array();
        $data->totalProduct = 0;

        //OSP when prices removed needed to format billTotal for AJAX
        if (!class_exists('CurrencyDisplay'))
            require(VMPATH_ADMIN . DS . 'helpers' . DS . 'currencydisplay.php');
        $currencyDisplay = CurrencyDisplay::getInstance();

        foreach ($cart->products as $i=>$product){

            $category_id = $cart->getCardCategoryId($product->virtuemart_product_id);

            //Create product URL
            $url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id, FALSE);
            $data->products[$i]['product_name'] = JHtml::link($url, $product->product_name);

            if(!class_exists('VirtueMartModelCustomfields'))require(VMPATH_ADMIN.DS.'models'.DS.'customfields.php');

            //  custom product fields display for cart
            $data->products[$i]['customProductData'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);
            $data->products[$i]['product_sku'] = $product->product_sku;
            $data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal']);

            // other possible option to use for display
            $data->products[$i]['subtotal'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal']);
            $data->products[$i]['subtotal_tax_amount'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_tax_amount']);
            $data->products[$i]['subtotal_discount'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal_discount']);
            $data->products[$i]['subtotal_with_tax'] = $currencyDisplay->priceDisplay($product->allPrices[$product->selectedPrice]['subtotal_with_tax']);
            
            // image product
            if (!empty($product->images[0])) {
                $data->products[$i]['image'] = $product->images[0]->displayMediaThumb ('', FALSE);
            }

            // UPDATE CART / DELETE FROM CART
            $data->products[$i]['quantity'] = $product->quantity;
            $data->totalProduct += $product->quantity ;

        }

        if(empty($cart->cartPrices['billTotal']) or $cart->cartPrices['billTotal'] < 0){
            $cart->cartPrices['billTotal'] = 0.0;
        }

        $data->billTotal = $currencyDisplay->priceDisplay( $cart->cartPrices['billTotal'] );
        $data->dataValidated = $cart->_dataValidated ;

        if ($data->totalProduct>1) $data->totalProductTxt = vmText::sprintf('COM_VIRTUEMART_CART_X_PRODUCTS', $data->totalProduct);
        else if ($data->totalProduct == 1) $data->totalProductTxt = vmText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
        else $data->totalProductTxt = vmText::_('COM_VIRTUEMART_EMPTY_CART');
        
        if (false && $data->dataValidated == true) {
            $taskRoute = '&task=confirm';
            $linkName = vmText::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU');
        } else {
            $taskRoute = '';
            $linkName = vmText::_('COM_VIRTUEMART_CART_SHOW');
        }

        $data->cart_show = '<a style ="float:right;" href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,true,VmConfig::get('useSSL',0)).'" rel="nofollow" >'.$linkName.'</a>';
        $data->billTotal = vmText::sprintf('COM_VIRTUEMART_CART_TOTALP',$data->billTotal);

        return $data ;
    }
    
    static function getDataAjax(){
        
        // load config VM
        self::loadConfigVM();
        
        // load VM cart
        self::loadVMcart();
        
        $module = JModuleHelper::getModule(self::$_MOD_PREFIX);
        
        if(!$module) {return false;}
        
        return JModuleHelper::renderModule($module);
    }
    
    static function updateCartAjax(){
        
        // load config VM
        self::loadConfigVM();
        
        // load VM cart
        self::loadVMcart();
        
        $cart = VirtueMartCart::getCart();
        $cart->updateProductCart();  
        
        $module = JModuleHelper::getModule(self::$_MOD_PREFIX);
        
        if(!$module) {return false;}
        
        return JModuleHelper::renderModule($module);
    }
    
    static function loadConfigVM() {
        if (!class_exists( 'VmConfig' )) require(JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
        VmConfig::loadConfig();

        VmConfig::loadJLang(self::$_MOD_PREFIX, true);
        VmConfig::loadJLang(self::$_COM_PREFIX, true);
    }
    static function loadVMcart(){
        if(!class_exists('VirtueMartCart')) require(VMPATH_SITE.DS.'helpers'.DS.'cart.php');
    }
    
    static function addJSAjax(){
        // load config VM
        self::loadConfigVM();
        
        // load VM cart
        self::loadVMcart();
        
        $json = new stdClass();
        $cart = VirtueMartCart::getCart(false);
        if ($cart) {
            jimport('joomla.application.component.controller');
            require_once(implode(DS, array(JPATH_SITE, 'components', 'com_virtuemart', 'controllers', 'cart.php')));
            $controller = new VirtueMartControllerCart();
            $controller->addViewPath(implode(DS, array(JPATH_SITE, 'components', 'com_virtuemart', 'views')));
            $view = $controller->getView ('cart', 'json'); 
            if(!class_exists('shopFunctionsF')) {
                require_once(implode(DS, array(JPATH_SITE, 'components', 'com_virtuemart', 'helpers', 'shopfunctionsf.php')));   
            }
            $virtuemart_category_id = shopFunctionsF::getLastVisitedCategoryId();
            $categoryLink='';
            if ($virtuemart_category_id) {
                $categoryLink = '&view=category&virtuemart_category_id=' . $virtuemart_category_id;
            }

            $continue_link = JRoute::_('index.php?option=com_virtuemart' . $categoryLink);

            $virtuemart_product_ids = vRequest::getInt('virtuemart_product_id');

            
            $view = $controller->getView ('cart', 'json');
            $errorMsg = 0;//vmText::_('COM_VIRTUEMART_CART_PRODUCT_ADDED');

            $products = $cart->add($virtuemart_product_ids, $errorMsg );

            $view->addTemplatePath(implode(DS, array(JPATH_THEMES, self::getTemplate(), 'html', 'com_virtuemart', 'cart')));
            $view->setLayout('padded');
            $json->stat = '1';
            
            if(!$products or count($products) == 0){
                $view->setLayout('perror');
                $json->stat = '2';

            }
            $view->assignRef('products',$products);
            $view->assignRef('errorMsg',$errorMsg);

            ob_start();
            $view->display ();
            $json->msg = ob_get_clean();
        } else {
            $json->msg = '<a href="' . JRoute::_('index.php?option=com_virtuemart', FALSE) . '" >' . vmText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') . '</a>';
            $json->msg .= '<p>' . vmText::_('COM_VIRTUEMART_MINICART_ERROR') . '</p>';
            $json->stat = '0';
        }
        
        // data 's cart
        $json->dcart = self::getData(true);
        
        return $json;   
    }
    
    private static function getTemplate(){
        return JFactory::getDbo()
        ->setQuery("SELECT template FROM #__template_styles WHERE client_id=0 AND home=1")
        ->loadObject()
        ->template;  
    }
}